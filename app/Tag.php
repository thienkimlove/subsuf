<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tag';
    protected $primaryKey = 'tag_id';
    public $timestamps = false;

    public function translations()
    {
        return $this->hasMany('App\TagTranslations', 'tag_id');
    }
}