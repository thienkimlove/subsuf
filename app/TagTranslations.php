<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagTranslations extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tag_translations';
    public $timestamps = false;
}