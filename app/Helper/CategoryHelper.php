<?php

namespace App\Helper;

class CategoryHelper
{
    public static function group_by_id($raw_data)
    {
        $data = [];

        foreach ($raw_data as $item) {
            $data[$item->category_id] = $item;
        }

        return $data;
    }
}