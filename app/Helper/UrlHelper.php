<?php

namespace App\Helper;

use Ixudra\Curl\Facades\Curl;

class AwsRequest
{

    protected static function awsQuery($extraParams, $host = "webservices.amazon.co.uk") {
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
        // create the canonicalized query
        $canonicalized_query = array();
        foreach ($params as $param => $value) {
            $param = str_replace("%7E", "~", rawurlencode($param));
            $value = str_replace("%7E", "~", rawurlencode($value));
            $canonicalized_query[] = $param . "=" . $value;
        }
        $canonicalized_query = implode("&", $canonicalized_query);

        // create the string to sign
        $string_to_sign =
            $method . "\n" .
            $host . "\n" .
            $uri . "\n" .
            $canonicalized_query;

        // calculate HMAC with SHA256 and base64-encoding
        $signature = base64_encode(
            hash_hmac("sha256", $string_to_sign, $private_key, True));

        // encode the signature for the equest
        $signature = str_replace("%7E", "~", rawurlencode($signature));

        // Put the signature into the parameters
        $params["Signature"] = $signature;
        uksort($params, "strnatcasecmp");

        // TODO: the timestamp colons get urlencoded by http_build_query
        //       and then need to be urldecoded to keep AWS happy. Spaces
        //       get reencoded as %20, as the + encoding doesn't work with
        //       AWS
        $query = urldecode(http_build_query($params));
        $query = str_replace(' ', '%20', $query);

        $string_to_send = "https://" . $host . $uri . "?" . $query;

        return $string_to_send;
    }

    public static function awsItemLookup($itemId, $host) {


        $items = [
            'name' => '',
            'price' => '0',
            'currency' => '',
            'description' => '',
            'images' => []
        ];

        $documentUrl = self::awsQuery(array (
            "AssociateTag" => env('AW_TAG'),
            "Operation" => "ItemLookup",
            "IdType" => "ISBN",
            "ItemId" => $itemId,
            "SearchIndex" => "All",
            "ResponseGroup" => "Large"
        ), $host);

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

        } catch (\Exception $e) {

        }

        return $items;

    }
}

class UrlHelper
{
    public static function curl($url)
    {
        return Curl::to($url)->withOption('SSL_VERIFYPEER', false)->get();
    }

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

    public static function crawl_amazon($url)
    {

        $host = null;

        if (strpos($url, 'amazon.co.uk') !== false) {
            $host = "webservices.amazon.co.uk";
        }

        if (strpos($url, 'amazon.com') !== false) {
            $host = "webservices.amazon.com";
        }

        $re = '/\/dp\/(.*)\//';
        $response = null;
        if (preg_match($re, $url, $matches)) {
            $response = AwsRequest::awsItemLookup($matches[1], $host);
        }

        return json_encode($response, true);

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
            return self::crawl_amazon($url);
        } elseif (strpos($url, 'ebay.com') !== false) {
            return self::crawl_ebay($url);
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