<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mysql';
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    public function websites()
    {
        return $this->hasMany('App\Website', 'category_id');
    }
}