<?php

namespace App\Helper;

use App\Exchange;
use Ixudra\Curl\Facades\Curl;
use DTS\eBaySDK\Shopping\Services;
use DTS\eBaySDK\Shopping\Types;


class UrlHelper
{
    public static function curl($url)
    {
        return Curl::to($url)->withOption('SSL_VERIFYPEER', false)->get();
    }

    /**
     * Author : QuanDM
     * Extract Ebay ItemId from Url
     * @param $str
     * @return null
     */
    public static function getEbayIdFromLink($str)
    {
        $re = '/\/(\d+)\?/';

        $ebayId = null;

        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

        if (preg_match($re, $str, $matches)) {
            $ebayId = $matches[1];
        }

        return $ebayId;
    }

    /**
     * Author : QuanDM
     * Create get item for Ebay using Ebay SDK
     * In case failed we using old version of Crawling
     * @param $url
     * @return array
     */
    public static function ebayItemLookup($url)
    {

        $items = [
            'name' => '',
            'price' => 0,
            'currency' => '',
            'description' => '',
            'images' => []
        ];


        $config = [
            'production' => [
                'credentials' => [
                    'devId' => env('EBAY_DEV_ID'),
                    'appId' => env('EBAY_APP_ID'),
                    'certId' => env('EBAY_CERT_ID'),
                ],
            ]
        ];

        $ebayId = self::getEbayIdFromLink($url);

        if ($ebayId) {
            $service = new Services\ShoppingService([
                'credentials' => $config['production']['credentials'],
                'apiVersion' => '903',
            ]);

            /**
             * Create the request object.
             */
            $request = new Types\GetSingleItemRequestType();

            /**
             * Specify the item ID of the listing.
             */
            $request->ItemID = $ebayId;

            /**
             * Specify that additional fields need to be returned in the response.
             */
            $request->IncludeSelector = 'Details';

            /**
             * Send the request.
             */
            $response = $service->getSingleItem($request);

            /**
             * Output the result of calling the service operation.
             */
            if (isset($response->Errors)) {
              \Log::info($response->Errors);
            }

            if ($response->Ack !== 'Failure') {
                $responseItem = $response->Item;
                $images  = [];
                foreach ($responseItem->PictureURL as $img) {
                    $images[] = $img;
                }

                $items = [
                    'name' => $responseItem->Title,
                    'price' => isset($responseItem->ConvertedCurrentPrice) ? $responseItem->ConvertedCurrentPrice->value : $responseItem->CurrentPrice->value,
                    'currency' => isset($responseItem->ConvertedCurrentPrice)? $responseItem->ConvertedCurrentPrice->currencyID :  $responseItem->CurrentPrice->currencyID,
                    'description' => $responseItem->Title,
                    'images' => $images
                ];
            }

        }
        return $items;
    }

    /**
     * Author : QuanDM
     * Get Amazon UK item using itemId
     * @param $url
     * @param $site
     * @return array
     */
    public static function awsItemLookup($url, $site)
    {

        $items = [
            'name' => '',
            'price' => 0,
            'currency' => '',
            'description' => '',
            'images' => []
        ];

        if ($site == 'UK') {
            $host = "webservices.amazon.co.uk";
            $tag  = env('AW_UK_TAG');
            $secret  = env('AW_UK_SECRET');
            $key  = env('AW_UK_KEY');
        }  else {
            $host = "webservices.amazon.com";
            $tag  = env('AW_US_TAG');
            $secret  = env('AW_US_SECRET');
            $key  = env('AW_US_KEY');
        }

        if (preg_match('/\\/([A-Z0-9]{10})($|\/)/', $url, $matches)) {

            $extraParams = [
                "AssociateTag" => $tag,
                "Operation" => "ItemLookup",
                "IdType" => "ISBN",
                "ItemId" => $matches[1],
                "SearchIndex" => "All",
                "ResponseGroup" => "Large"
            ];

            $private_key = $secret;
            $method = "GET";
            $uri = "/onca/xml";
            $params = array(
                "Service" => "AWSECommerceService",
                "AWSAccessKeyId" => $key,
                "Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
                "SignatureMethod" => "HmacSHA256",
                "SignatureVersion" => "2",
                "Version" => "2013-08-01"
            );

            foreach ($extraParams as $param => $value) {
                $params[$param] = $value;
            }

            ksort($params);

            // sort the parameters
            // create the $canonicalQuery query
            $canonicalQuery = array();
            foreach ($params as $param => $value) {
                $param = str_replace("%7E", "~", rawurlencode($param));
                $value = str_replace("%7E", "~", rawurlencode($value));
                $canonicalQuery[] = $param . "=" . $value;
            }
            $canonicalQuery = implode("&", $canonicalQuery);

            // create the string to sign
            $string_to_sign =
                $method . "\n" .
                $host . "\n" .
                $uri . "\n" .
                $canonicalQuery;

            // calculate HMAC with SHA256 and base64-encoding
            $signature = base64_encode(
                hash_hmac("sha256", $string_to_sign, $private_key, True));

            // encode the signature for the request
            $signature = str_replace("%7E", "~", rawurlencode($signature));

            // Put the signature into the parameters
            $params["Signature"] = $signature;
            uksort($params, "strnatcasecmp");

            $query = urldecode(http_build_query($params));
            $query = str_replace(' ', '%20', $query);

            $documentUrl = "https://" . $host . $uri . "?" . $query;

            try  {
                $xml = simplexml_load_file($documentUrl);


                if (isset($xml->Items->Item->ItemAttributes->Title[0])) {
                    $items['name'] = $xml->Items->Item->ItemAttributes->Title[0]->__toString();
                }

                if (isset($xml->Items->Item->ItemAttributes->Title)) {
                    $items['name'] = $xml->Items->Item->ItemAttributes->Title->__toString();
                }

                if (isset($xml->Items->Item->Offers->Offer->OfferListing->SalePrice)) {
                    $items['currency'] = $xml->Items->Item->Offers->Offer->OfferListing->SalePrice->CurrencyCode->__toString();
                    $items['price'] = $xml->Items->Item->Offers->Offer->OfferListing->SalePrice->Amount / 100;
                } elseif (isset($xml->Items->Item->Offers->Offer->OfferListing->Price)) {
                    $items['currency'] = $xml->Items->Item->Offers->Offer->OfferListing->Price->CurrencyCode->__toString();
                    $items['price'] = $xml->Items->Item->Offers->Offer->OfferListing->Price->Amount / 100;
                } elseif (isset($xml->Items->Item->ItemAttributes->ListPrice)) {
                    $items['currency'] = $xml->Items->Item->ItemAttributes->ListPrice->CurrencyCode->__toString();
                    $items['price'] = $xml->Items->Item->ItemAttributes->ListPrice->Amount / 100;
                }

                if (isset($xml->Items->Item->ImageSets->ImageSet)) {
                    foreach ($xml->Items->Item->ImageSets->ImageSet as $feature) {
                        if (isset($feature->HiResImage->URL)) {
                            $items['images'][] = $feature->HiResImage->URL->__toString();
                        }
                    }
                }

                if (isset($xml->Items->Item->ImageSets->ImageSet->SwatchImage->URL)) {
                    $items['images'][] = $xml->Items->Item->ImageSets->ImageSet->SwatchImage->URL->__toString();
                }

                if (isset($xml->Items->Item->ImageSets->ImageSet->SmallImage->URL)) {
                    $items['images'][] = $xml->Items->Item->ImageSets->ImageSet->SmallImage->URL->__toString();
                }

                if (isset($xml->Items->Item->ImageSets->ImageSet->ThumbnailImage->URL)) {
                    $items['images'][] = $xml->Items->Item->ImageSets->ImageSet->ThumbnailImage->URL->__toString();
                }

                if (isset($xml->Items->Item->ImageSets->ImageSet->TinyImage->URL)) {
                    $items['images'][] = $xml->Items->Item->ImageSets->ImageSet->TinyImage->URL->__toString();
                }

                foreach ($xml->Items->Item->ImageSets->ImageSet as $feature) {
                    if (isset($feature->HiResImage->URL)) {
                        $items['images'][] = $feature->HiResImage->URL->__toString();
                    } else if (isset($feature->ThumbnailImage->URL)) {
                        $items['images'][] = $feature->ThumbnailImage->URL->__toString();
                    } else if (isset($feature->SmallImage->URL)) {
                        $items['images'][] = $feature->SmallImage->URL->__toString();
                    } else if (isset($feature->TinyImage->URL)) {
                        $items['images'][] = $feature->TinyImage->URL->__toString();
                    } else if (isset($feature->SwatchImage->URL)) {
                        $items['images'][] = $feature->SwatchImage->URL->__toString();
                    }
                }

                if (isset($xml->Items->Item->MediumImage->URL)) {
                    $items['images'][] = $xml->Items->Item->MediumImage->URL->__toString();
                }

                if (isset($xml->Items->Item->ItemAttributes->Feature)) {
                    foreach ($xml->Items->Item->ItemAttributes->Feature as $feature) {
                        $items['description'] .= $feature->__toString()."\n";
                    }
                }

            } catch (\Exception $e) {
                \Log::info($e->getMessage());
            }
        }

        return $items;
    }

    private static function getMetaTags($str)
    {
        $pattern = '
          ~<\s*meta\s
        
          # using lookahead to capture type to $1
            (?=[^>]*?
            \b(?:name|property|http-equiv)\s*=\s*
            (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
            ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
          )
        
          # capture content to $2
          [^>]*?\bcontent\s*=\s*
            (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
            ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
          [^>]*>
        
          ~ix';

        if(preg_match_all($pattern, $str, $out))
            return array_combine($out[1], $out[2]);
        return array();
    }

    /**
     * We only accept three currencies : GBP, JPY and USD
     * @param $url
     * @return string
     */
    public static function crawl($url)
    {
        if (strpos($url, 'amazon.co.uk') !== false) {
            $trueResponse = self::awsItemLookup($url, 'UK');
        } elseif (strpos($url, 'ebay.com') !== false) {
            $trueResponse = self::ebayItemLookup($url);
        }  elseif (strpos($url, 'amazon.com') !== false) {
            $trueResponse = self::awsItemLookup($url, 'US');
        } else {
            $items = [
                'name' => '',
                'price' => 0,
                'currency' => '',
                'description' => '',
                'images' => []
            ];
            $html = self::curl($url);
            $metaTags = self::getMetaTags($html);

            if (isset($metaTags['og:image'])) {
                $items['images'][] = $metaTags['og:image'];
            }

            if (isset($metaTags['og:title'])) {
                $items['name'] = htmlspecialchars_decode($metaTags['og:title']);
            }

            if (isset($metaTags['og:description'])) {
                $items['description'] = htmlspecialchars_decode($metaTags['og:description']);
            } elseif (isset($metaTags['description'])) {
                $items['description'] = $metaTags['description'];
            }
            $trueResponse = $items;
        }

        if ($trueResponse['currency']) {
            if (!in_array($trueResponse['currency'], ['GBP', 'JPY', 'USD'])) {
                $trueResponse['price'] = 0;
                $trueResponse['display_price'] = 0;
                $trueResponse['display_currency'] = 'USD';
            } elseif ($trueResponse['currency'] != 'USD') {
                $exchange = Exchange::where('from_currency', $trueResponse['currency'])->where('to_currency', 'USD')->get();
                if ($exchange->count() > 0) {
                    $trueResponse['display_price'] = $trueResponse['price'];
                    $trueResponse['price'] = round($trueResponse['price']*$exchange->first()->money, 2);
                    $trueResponse['display_currency'] = $trueResponse['currency'];
                } else {
                    $trueResponse['price'] = 0;
                    $trueResponse['display_price'] = 0;
                    $trueResponse['display_currency'] = 'USD';
                }
            } else {
                $trueResponse['display_price'] = $trueResponse['price'];
                $trueResponse['display_currency'] = 'USD';
            }
        }


        return json_encode($trueResponse, true);
    }
}