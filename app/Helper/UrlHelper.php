<?php

namespace App\Helper;

use Ixudra\Curl\Facades\Curl;

class UrlHelper
{
    private static function curl($url)
    {
        return Curl::to($url)->withOption('SSL_VERIFYPEER', false)->get();
    }

    private static function currency($string)
    {
        $currencySymbols = [
            '£',
            '$'
        ];
        foreach ($currencySymbols as $currencySymbol) {
            if (strpos($string, $currencySymbol) !== false) {
                return $currencySymbol;
            }
        }

        return "$";
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

        dd($html);

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
            return self::crawl_amazon_uk($url);
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