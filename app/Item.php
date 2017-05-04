<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'mysql';
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id')
            ->select(['category_id', 'name']);
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id')
            ->select(['brand_id', 'name']);
    }
    public function item_images()
    {
        return $this->hasMany('App\ItemImage', 'item_id');
    }
}