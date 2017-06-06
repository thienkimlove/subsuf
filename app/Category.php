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

class Category extends Model
{
    protected $fillable = [
        'category_type',
        'name',
        'image',
        'category_order',
        'is_showed'
    ];

    use Translatable;

    public $translatedAttributes = ['name'];

    public $translationModel = 'App\CategoryTranslation';

    protected $connection = 'mysql';
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    public $timestamps = false;

    public function websites()
    {
        return $this->hasMany('App\Website', 'category_id');
    }
}