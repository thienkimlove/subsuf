<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $connection = 'mysql';
    protected $table = 'transaction';
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;

    public function offer()
    {
        return $this->belongsTo('App\Offer', 'offer_id');
    }

    public function coupon()
    {
        return $this->hasOne('App\Coupon', 'coupon_id', 'coupon_id');
    }
}