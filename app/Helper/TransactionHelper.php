<?php

/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/19/2016
 * Time: 9:05 AM
 */
namespace App\Helper;

class TransactionHelper
{
    public static function transaction_index($data)
    {
        $statistics = [
            'number' => [
                'total' => 0,
                'new' => 0,
                'trading' => 0,
                'done' => 0,
            ],
            'percent' => [
                'new' => 0,
                'trading' => 0,
                'done' => 0,
            ]
        ];

        foreach ($data as $item) {
            $statistics['number']['total'] += 1;
            switch ($item->transaction_status) {
                case -1:
                default:
                    break;
                case 2:
                    $statistics['number']['trading'] += 1;
                    break;
                case 3:
                    $statistics['number']['done'] += 1;
                    break;
            }

            if ($item->transaction_date == date('Y-m-d')) {
                $statistics['number']['new'] += 1;
            }
        }

        if ($statistics['number']['total'] > 0) {
            $statistics['percent']['new'] = round(100 * $statistics['number']['new'] / $statistics['number']['total'], 1);
            $statistics['percent']['trading'] = round(100 * $statistics['number']['trading'] / $statistics['number']['total'], 1);
            $statistics['percent']['done'] = round(100 * $statistics['number']['done'] / $statistics['number']['total'], 1);
        }

        return $statistics;
    }
}