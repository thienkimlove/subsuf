<?php

namespace App\Helper;

use App\Exchange;
use Ixudra\Curl\Facades\Curl;
use DTS\eBaySDK\Shopping\Services;
use DTS\eBaySDK\Shopping\Types;
use DTS\eBaySDK\Shopping\Enums;


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
            'price' => '0',
            'amount' => '0',
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
                    'price' => $responseItem->CurrentPrice->value,
                    'amount' => isset($responseItem->ConvertedCurrentPrice) ? $responseItem->ConvertedCurrentPrice->value : $responseItem->CurrentPrice->value,
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
            'price' => '0',
            'amount' => '0',
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
                    $items['price'] = $xml->Items->Item->Offers->Offer->OfferListing->SalePrice->FormattedPrice->__toString();
                    $items['currency'] = $xml->Items->Item->Offers->Offer->OfferListing->SalePrice->CurrencyCode->__toString();
                    $items['amount'] = $xml->Items->Item->Offers->Offer->OfferListing->SalePrice->Amount / 100;
                } elseif (isset($xml->Items->Item->Offers->Offer->OfferListing->Price)) {
                    $items['price'] = $xml->Items->Item->Offers->Offer->OfferListing->Price->FormattedPrice->__toString();
                    $items['currency'] = $xml->Items->Item->Offers->Offer->OfferListing->Price->CurrencyCode->__toString();
                    $items['amount'] = $xml->Items->Item->Offers->Offer->OfferListing->Price->Amount / 100;
                } elseif (isset($xml->Items->Item->ItemAttributes->ListPrice)) {
                    $items['price'] = $xml->Items->Item->ItemAttributes->ListPrice->FormattedPrice->__toString();
                    $items['currency'] = $xml->Items->Item->ItemAttributes->ListPrice->CurrencyCode->__toString();
                    $items['amount'] = $xml->Items->Item->ItemAttributes->ListPrice->Amount / 100;
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


    //old code
    public static function crawl_amazon_us($url)
    {
        $post = [
            'name' => '',
            'price' => '0',
            'amount' => '0',
            'currency' => '',
            'description' => '',
            'images' => []
        ];

        $html = self::curl($url);


        if ($html) {
            $html = preg_replace("/(\\n|\\r|\\t)/", "", $html);
            if (preg_match("/<span id=\"productTitle.*?>(.*?)<\/span>/", $html, $m)) {
                $post["name"] = trim($m[1]);
            }

            if (preg_match("/<span id=\"priceblock_ourprice\".*?>(.*?)<\/span>/", $html, $m)) {
                $post["price"] = preg_replace("/[^0-9.]/", "", trim($m[1]));
                // $post["currency"] = self::currency(trim($m[1]));
            } elseif (preg_match("/<span id=\"priceblock_saleprice\".*?>(.*?)<\/span>/", $html, $m)) {
                $post["price"] = preg_replace("/[^0-9.]/", "", trim($m[1]));
                // $post["currency"] = self::currency(trim($m[1]));
            }

            if (preg_match("/<div id=\"productDescription\".*?>.*?<p.*?>(.*?)<\/p>.*?<\/div>/", $html, $m)) {
                $post["description"] = trim($m[1]);
            } elseif (preg_match("/<ul class=\"a-vertical a-spacing-none\">.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>/", $html, $m)) {
                $post["description"] = trim($m[1]) . trim($m[2]) . trim($m[3]) . trim($m[4]) . trim($m[5]);
            }

            if (preg_match_all("/<li class=\"a-spacing-small item\".*?>.*?<img.*?src=\"(.*?)\">/", $html, $m)) {
                for ($i = 0; $i < 5; $i++) {
                    if (isset($m[1][$i])) {
//                        array_push($post["images"], preg_replace(["/._SX38_SY50_CR,0,0,38,50_/", "/._SS40_/", "/._SR38,50_/"], "", $m[1][$i]));
                        array_push($post["images"], preg_replace(["/\._(.*?)_\./"], ".", $m[1][$i]));
                    }
                }
            }
        }


        return json_encode($post);
    }

    public static function crawl_amazon_uk($url)
    {
        $post = [
            'name' => '',
            'price' => '0',
            'amount' => '0',
            'currency' => '',
            'description' => '',
            'images' => []
        ];

        $html = self::curl($url);

        if ($html) {
            $html = preg_replace("/(\\n|\\r|\\t)/", "", $html);
            if (preg_match("/<span id=\"productTitle.*?>(.*?)<\/span>/", $html, $m)) {
                $post["name"] = trim($m[1]);
            }

            if (preg_match("/<span id=\"priceblock_ourprice\".*?>(.*?)<\/span>/", $html, $m)) {
                $post["price"] = preg_replace("/[^0-9.]/", "", trim($m[1]));
                $post["amount"] = preg_replace("/[^0-9.]/", "", trim($m[1]));
                $post["currency"] = self::currency(trim($m[1]));
            } elseif (preg_match("/<span id=\"priceblock_saleprice\".*?>(.*?)<\/span>/", $html, $m)) {
                $post["price"] = preg_replace("/[^0-9.]/", "", trim($m[1]));
                $post["currency"] = self::currency(trim($m[1]));
            }


            if (preg_match("/<div id=\"productDescription\".*?>.*?<p.*?>(.*?)<\/p>.*?<\/div>/", $html, $m)) {
                $post["description"] = strip_tags(trim($m[1]));
            } elseif (preg_match("/<ul class=\"a-vertical a-spacing-none\">.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>.*?<span class=\"a-list-item\">(.*?)<\/span>/", $html, $m)) {
                $post["description"] = trim($m[1]) . trim($m[2]) . trim($m[3]) . trim($m[4]) . trim($m[5]);
            }

            if (preg_match_all("/<li class=\"a-spacing-small item\".*?>.*?<img.*?src=\"(.*?)\">/", $html, $m)) {
                for ($i = 0; $i < 5; $i++) {
                    if (isset($m[1][$i])) {
//                            array_push($post["images"], preg_replace(["/._SX38_SY50_CR,0,0,38,50_/", "/._SS40_/", "/._SR38,50_/"], "", $m[1][$i]));
                        array_push($post["images"], preg_replace(["/\._(.*?)_\./"], ".", $m[1][$i]));
                    }
                }
            }

            return json_encode($post);
        }
    }

    public static function crawl_ebay($url)
    {
        $post = [
            'name' => '',
            'price' => '0',
            'currency' => '$',
            'description' => '',
            'images' => []
        ];

        $html = self::curl($url);

        if ($html) {
            $html = preg_replace("/(\\n|\\r|\\t)/", "", $html);
            if (preg_match("/<h1 class=\"it-ttl\".*?>.*?<\/span>(.*?)<\/h1>/", $html, $m)) {
                $post["name"] = trim($m[1]);
            }

            if (preg_match("/<span class=\"notranslate\".*?>(.*?)<\/span>/", $html, $m)) {
                $post["price"] = preg_replace("/[^0-9.]/", "", trim($m[1]));
                $post["currency"] = self::currency(trim($m[1]));
            }

            if (preg_match("/<h1 class=\"it-ttl\".*?>.*?<\/span>(.*?)<\/h1>/", $html, $m)) {
                $post["description"] = trim($m[1]);
            }

            if (preg_match_all("/<table class=\"img\">.*?<img.*?src=\"(.*?)\" .*?>.*?<\/table>/", $html, $m)) {
                for ($i = 0; $i < 5; $i++) {
                    if (isset($m[1][$i])) {
                        array_push($post["images"], preg_replace(["/s-l64/"], "s-l500", $m[1][$i]));
                    }
                }
            } elseif (preg_match_all("/<img id=\"icThrImg\".*?>.*?<img id=\"icImg\" class=\"img img300\".*?src=\"(.*?)\".*?>/", $html, $m)) {
                for ($i = 0; $i < 5; $i++) {
                    if (isset($m[1][$i])) {
                        array_push($post["images"], preg_replace("/._SR38,50_/", "", $m[1][$i]));
                    }
                }
            }
        }

        return json_encode($post);
    }

    public static function crawl_overstock($url)
    {
        $post = [
            'name' => '',
            'price' => '0',
            'amount' => '0',
            'currency' => '',
            'description' => '',
            'images' => []
        ];

        $html = self::curl($url);

        if ($html) {
            $html = preg_replace("/(\\n|\\r|\\t)/", "", $html);
            if (preg_match("/<div class=\"product-title\".*?>.*?<h1>(.*?)<\/h1>/", $html, $m)) {
                $post["name"] = trim($m[1]);
            }


           if (preg_match("/<span class=\"monetary-price.*?>(.*?)<\/span>/", $html, $m)) {
             $post["price"] = preg_replace("/[^0-9.]/", "", trim($m[1]));
           }


            if (preg_match("/<span itemprop=\"description\".*?>(.*?)<\/span>/", $html, $m)) {
                $post["description"] = trim(preg_replace(["/<li.*?>/", "/<\/li>/", "/<ul.*?>/", "/<\/ul>/", "/<br.*?>/", "/<\/br>/"], "", $m[1]));
            }
            
            if (preg_match_all("/<li class=\"\" data-image-id.*?>.*?<img.*?src=\"(.*?)\".*?>/", $html, $m)) {
                for ($i = 0; $i < 5; $i++) {
                    if (isset($m[1][$i])) {
                        array_push($post['images'], preg_replace("/_80/", "", $m[1][$i]));
                    }
                }
            }
        }

        return json_encode($post);
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
                'price' => '0',
                'amount' => '0',
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
                $trueResponse['currency'] = '';
                $trueResponse['price'] = 0;
                $trueResponse['amount'] = 0;
            } elseif ($trueResponse['currency'] != 'USD') {
                $exchange = Exchange::where('from_currency', $trueResponse['currency'])->where('to_currency', 'USD')->get();
                if ($exchange->count() > 0) {
                    $trueResponse['exchange'] = round($trueResponse['amount']*$exchange->first()->money, 2).' USD';
                }
            }
        }


        return json_encode($trueResponse, true);
    }
}