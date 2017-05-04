<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayPalInfo extends Model
{
    protected $connection = 'mysql';
    protected $table = 'paypal_info';
    protected $primaryKey = 'payment_info_id';
    public $timestamps = false;
}