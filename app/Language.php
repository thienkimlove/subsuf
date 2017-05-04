<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $connection = 'mysql';
    protected $table = 'language';
    protected $primaryKey = 'language_code';
    public $timestamps = false;
    public $incrementing = false;
}