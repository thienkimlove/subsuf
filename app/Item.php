<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'price',
        'name',
        'label',
        'link',
        'image',
        'featured',
        'description',
        'status',
        'item_order',
        'is_showed',
        'is_sale',
        'price_sale'
    ];

    use Translatable;
    public $translatedAttributes = ['name'];
    public $translationModel = 'App\ItemTranslation';

    protected $connection = 'mysql';
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    public $timestamps = false;

    protected $fillable = [
        'item_id',
        'category_id',
        'brand_id',
        'price',
        'label',
        'link',
        'image',
        'featured',
        'status',
        'item_order',
        'is_showed',
        'is_sale',
        'price_sale',
    ];

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