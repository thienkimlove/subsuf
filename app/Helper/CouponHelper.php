<?php

namespace App\Helper;

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
}