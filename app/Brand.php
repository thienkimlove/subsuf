<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $connection = 'mysql';
    protected $table = 'brand';
    protected $primaryKey = 'brand_id';
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany('App\Item', 'brand_id');
    }
}