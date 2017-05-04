<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticContent extends Model
{
    protected $connection = 'mysql';
    protected $table = 'static_content';
    public $timestamps = false;

    public function language_ref()
    {
        return $this->hasOne('App\Language', 'language_code', 'language');
    }
}