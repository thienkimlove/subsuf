<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    protected $connection = 'mysql';
    protected $table = 'orders_image';
    protected $primaryKey = 'order_image_id';
    public $timestamps = false;
}