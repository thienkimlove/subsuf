<?php

namespace App\Helper;

class LocationHelper
{
    public static function group_by_id($raw_data)
    {
        $data = [];

        foreach ($raw_data as $item) {
            $data[$item->location_id] = $item;
        }

        return $data;
    }
}