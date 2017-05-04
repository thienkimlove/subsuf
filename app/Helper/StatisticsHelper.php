<?php

namespace App\Helper;

class StatisticsHelper
{
    public static function order_by_user($data)
    {
        $statistics = [
            -1 => [],
            1 => [],
            2 => [],
            3 => []
        ];

        foreach ($data as $item) {
            if (key_exists($item['order_status'], $statistics)) {
                $statistics[$item['order_status']][] = $item;
            }
        }

        return $statistics;
    }

    public static function order_by_location($data)
    {
        $statistics = [
            'total' => [
                'orders' => 0,
                'offers' => 0,
            ],
            'percent' => []
        ];

        foreach ($data as $item) {
            $deliver_to = $item['deliver_to'];

            if (!key_exists($deliver_to, $statistics)) {
                $statistics[$deliver_to] = [
                    'orders' => 0,
                    'offers' => 0,
                    'rewards' => 0
                ];
            }

            $statistics[$deliver_to]['orders'] += 1;
            $statistics[$deliver_to]['offers'] += count($item->offers);
            $statistics[$deliver_to]['rewards'] += $item->traveler_reward;

            $statistics['total']['orders'] += 1;
            $statistics['total']['offers'] += count($item->offers);
        }

        if ($statistics['total']['orders'] > 0) {
            foreach ($statistics as $key => $tmp) {
                if ($key == 'total' || $key == 'percent') {
                    continue;
                }

                $statistics['percent'][$key] = round(100 * $statistics[$key]['orders'] / $statistics['total']['orders'], 2);
            }
        }

        return $statistics;
    }

    public static function revenue_traveler($transactions, $start, $end)
    {
        $statistics = [
            'total_temp' => 0,
            'total_reality' => 0
        ];
        $days = get_day($start, $end);
        $data_reality = [];
        $data_temp = [];

        foreach ($days as $day) {
            $data_reality[$day] = 0;
            $data_temp[$day] = 0;
        }

        foreach ($transactions as $transaction) {
            $transaction_date = $transaction->transaction_date;

            $offer = $transaction->offer;
            $order = $offer->order;

            $money = $offer->shipping_fee + $offer->tax + $offer->others_fee + $order->price * $order->quantity;

            $data_temp[$transaction_date] += $money;
            $statistics['total_temp'] += $money;

            if ($transaction->transaction_status == 3) {
                $data_reality[$transaction_date] += $money;
                $statistics['total_reality'] += $money;
            }
        }

        $statistics['days'] = $days;
        $statistics['data_reality'] = $data_reality;
        $statistics['data_temp'] = $data_temp;

        return $statistics;
    }

    public static function revenue($transactions, $start, $end)
    {
        $statistics = [
            'total_temp' => 0,
            'total_reality' => 0
        ];
        $days = get_day($start, $end);
        $data_reality = [];
        $data_temp = [];

        foreach ($days as $day) {
            $data_reality[$day] = 0;
            $data_temp[$day] = 0;
        }

        foreach ($transactions as $transaction) {
            $transaction_date = $transaction->transaction_date;

            $money = $transaction->service_fee;

            $data_temp[$transaction_date] += $money;
            $statistics['total_temp'] += $money;

            if ($transaction->transaction_status == 3) {
                $data_reality[$transaction_date] += $money;
                $statistics['total_reality'] += $money;
            }
        }

        $statistics['days'] = $days;
        $statistics['data_reality'] = $data_reality;
        $statistics['data_temp'] = $data_temp;

        return $statistics;
    }
}