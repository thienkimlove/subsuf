<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'desc'];
}