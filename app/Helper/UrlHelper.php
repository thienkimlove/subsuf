<?php

namespace App\Helper;

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
     * @return string
     */
    public static function ebayItemLookup($url)
    {

        $item = [];


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

                $description = null;
                $shipping = ($responseItem->GlobalShipping) ? 'Yes' : 'No';
                $description .= 'Location : '.$responseItem->Location."\n";
                $description .= 'Global Shipping : '. $shipping;


                $item = [
                    'name' => $responseItem->Title,
                    'price' => $responseItem->CurrentPrice->value,
                    'amount' => $responseItem->CurrentPrice->value,
                    'currency' => $responseItem->CurrentPrice->currencyID,
                    'description' => $description,
                    'images' => $images
                ];
            }

        }
        if ($item) {
            return json_encode($item);
        } else {
            return self::crawl_ebay($url);
        }
    }

    /**
     * Author : QuanDM
     * Get Amazon UK item using itemId
     * @param $url
     * @return null|string
     */
    public static function awsItemLookup($url)
    {

        $host = "webservices.amazon.co.uk";
        $re = '/\/dp\/(.*)\//';
        $response = null;
        if (preg_match($re, $url, $matches)) {

            $items = [
                'name' => '',
                'price' => '0',
                'amount' => '0',
                'currency' => '',
                'description' => '',
                'images' => []
            ];

            $extraParams = [
                "AssociateTag" => env('AW_TAG'),
                "Operation" => "ItemLookup",
                "IdType" => "ISBN",
                "ItemId" => $matches[1],
                "SearchIndex" => "All",
                "ResponseGroup" => "Large"
            ];

            $private_key = env('AW_SECRET');
            $method = "GET";
            $uri = "/onca/xml";
            $params = array(
                "Service" => "AWSECommerceService",
                "AWSAccessKeyId" => env('AW_ID'),
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

                $items['name'] = $xml->Items->Item->ItemAttributes->Title[0]->__toString();
                $items['price'] = $xml->Items->Item->ItemAttributes->ListPrice->FormattedPrice->__toString();
                $items['currency'] = $xml->Items->Item->ItemAttributes->ListPrice->CurrencyCode->__toString();
                $items['amount'] = $xml->Items->Item->ItemAttributes->ListPrice->Amount/100;
                foreach ($xml->Items->Item->ImageSets->ImageSet as $feature) {
                    $items['images'][] = $feature->HiResImage->URL->__toString();
                }
                foreach ($xml->Items->Item->ItemAttributes->Feature as $feature) {
                    $items['description'] .= $feature->__toString()."\n";
                }
                $response = json_encode($items, true);

            } catch (\Exception $e) {

            }
        }

        if ($response) {
            return $response;
        } else {
            return self::crawl_amazon_uk($url);
        }
    }

    //old code
    public static function crawl_amazon_us($url)
    {
        $post = [
            'name' => '',
            'price' => '0',
            'currency' => 'USD',
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
            'currency' => '$',
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
            'currency' => '$',
            'description' => '',
            'images' => []
        ];

        $html = self::curl($url);

        if ($html) {
            $html = preg_replace("/(\\n|\\r|\\t)/", "", $html);
            if (preg_match("/<div itemprop=\"name\".*?>.*?<h1>(.*?)<\/h1>/", $html, $m)) {
                $post["name"] = trim($m[1]);
            }

            /**
             * if (preg_match("/<span class=\"monetary-price.*?>(.*?)<\/span>/", $html, $m)) {
             * $post["price"] = preg_replace("/[^0-9.]/", "", trim($m[1]));
             * }
             * **/

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

    public static function crawl($url)
    {
        if (strpos($url, 'amazon.co.uk') !== false) {
            return self::awsItemLookup($url);
        } elseif (strpos($url, 'ebay.com') !== false) {
            return self::ebayItemLookup($url);
        } elseif (strpos($url, 'overstock.com') !== false) {
            return self::crawl_overstock($url);
        } elseif (strpos($url, 'amazon.com') !== false) {
            return self::crawl_amazon_us($url);
        } else {
            return json_encode([
                'name' => '',
                'price' => '0',
                'currency' => '$',
                'description' => '',
                'images' => []
            ]);
        }
    }
}