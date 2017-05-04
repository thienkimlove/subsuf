<?php

/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/19/2016
 * Time: 9:05 AM
 */
namespace App\Helper;

class OrderHelper
{
    public static function order_index($data)
    {
        $statistics = [
            'money' => [
                'total' => 0,
                'valuable' => 0
            ],
            'order' => [
                'total' => 0,
                'new' => 0,
                'out' => 0
            ],
            'percent' => [
                'money' => 0,
                'new' => 0,
                'out' => 0
            ]
        ];

        foreach ($data as $item) {
            $money = $item->price * $item->quantity;
            $statistics['money']['total'] += $money;
            if ($item->order_status != -1) {
                $statistics['money']['valuable'] += $money;
            }

            $statistics['order']['total'] += 1;
            $request_date = date('Ymd', strtotime($item->request_time));
            if ($item->deliver_date < date('Y-m-d')) {
                $statistics['order']['out'] += 1;
            } elseif ($request_date == date('Ymd')) {
                $statistics['order']['new'] += 1;
            }
        }

        if ($statistics['money']['total'] > 0) {
            $statistics['percent']['money'] = round(100 * $statistics['money']['valuable'] / $statistics['money']['total'], 1);
        }

        if ($statistics['order']['total'] > 0) {
            $statistics['percent']['new'] = round(100 * $statistics['order']['new'] / $statistics['order']['total'], 1);
            $statistics['percent']['out'] = round(100 * $statistics['order']['out'] / $statistics['order']['total'], 1);
        }

        return $statistics;
    }
}