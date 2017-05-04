<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    protected $connection = 'mysql';
    protected $table = 'item_image';
    protected $primaryKey = 'image_id';
    public $timestamps = false;

}