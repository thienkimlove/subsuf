<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $connection = 'mysql';
    protected $table = 'faq';
    protected $primaryKey = 'faq_id';
    public $timestamps = false;

    public function language_ref()
    {
        return $this->hasOne('App\Language', 'language_code', 'language');
    }
}