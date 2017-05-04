<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $connection = 'mysql';
    protected $table = 'coupon';
    protected $primaryKey = 'coupon_id';
    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id')
            ->select(['account_id', 'first_name', 'last_name', 'email', 'phone_number']);
    }
   
}