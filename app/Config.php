<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $connection = 'mysql';
    protected $table = 'config';
    protected $primaryKey = 'config_key';

    public function getConfig($key)
    {
        $config = Config::find($key);
        if ($config) {
            return $config->config_value;
        }
        return false;
    }

    public function getCouponRegiter()
    {
        $coupon = self::getConfig("coupon_register");
        return (float)$coupon;
    }
    public function getCouponInvite()
    {
        $coupon = self::getConfig("coupon_invite");
        return (float)$coupon;
    }
}