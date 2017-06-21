<?php

namespace App\Helper;

use App\Exchange;

class CouponHelper
{
    /**
     * Calculate real coupon amount by type and total order amount
     * @param $absoluteTotal
     * @param $coupon_money
     * @param $coupon_type
     * @param int $coupon_primary_percent
     * @param int $coupon_secondary_percent
     * @return float|int
     */
    public static function getRealCouponAmountByTotal($absoluteTotal, $coupon_money, $coupon_type, $coupon_primary_percent = 0, $coupon_secondary_percent = 0)
    {
        $amount_be_coupon = $coupon_money;
        if ($coupon_type == 1) {
            $amount_be_coupon = ($coupon_primary_percent/100)*$absoluteTotal;
            if ($amount_be_coupon > $coupon_money) {
                $amount_be_coupon = $coupon_money;
            }
        } else if ($coupon_type == 2) {
            if ($absoluteTotal > $coupon_money) {
                $amount_be_coupon = ($coupon_secondary_percent/100)*$absoluteTotal;
            } else {
                $amount_be_coupon = ($coupon_primary_percent/100)*$absoluteTotal;
            }
        }
        return $amount_be_coupon;
    }

    public static function checkCouponForUser($sessionUser, $coupon, $total)
    {

        if ($coupon->promotion_email && $sessionUser["email"] != $coupon->promotion_email) {
            $data = [
                "status" => 0,
                "message" => "Mã coupon không đúng email!",
            ];
        } else if ($coupon->account_id != 0 && $sessionUser["account_id"] != $coupon->account_id) {
            $data = [
                "status" => 0,
                "message" => "Mã coupon đã xác định dùng cho user khác!",
            ];
        } else  {

            $exchange = Exchange::where('from_currency', 'USD')->where('to_currency', 'VND')->first();

            $exchangeRatio = $exchange->money;

            if(str_contains($coupon->coupon_code, 'PROMO'))
            {
                $total = $total * $exchangeRatio;
            }

            if ($coupon->money > $total && $coupon->type == 0) {
                $data = [
                    "status" => 0,
                    "message" => "Mã coupon có số tiền khuyến mại lớn hơn tổng tiền đơn hàng nên không thể áp dụng!",
                ];

            } else {
                $amount_be_coupon = CouponHelper::getRealCouponAmountByTotal($total, $coupon->money, $coupon->type, $coupon->primary_percent, $coupon->secondary_percent);
                $responseData = $coupon->toArray();
                $responseData['amount_be_coupon'] = $amount_be_coupon;
                $responseData['coupon_currency'] = $coupon->currency;

                $data = [
                    "status" => 1,
                    "data" => $responseData,
                ];
            }
        }

        return $data;
    }
}