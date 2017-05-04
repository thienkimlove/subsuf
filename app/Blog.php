<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $connection = 'mysql';
    protected $table = 'blog';
    protected $primaryKey = 'blog_id';
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo('App\BlogCategory', 'category_id');
    }

    public function language_ref()
    {
        return $this->hasOne('App\Language', 'language_code', 'language');
    }

    public function author()
    {
        return $this->belongsTo('App\Admin', 'author_id', 'admin_id')
            ->select(['name', 'tag', 'admin_id']);
    }
}