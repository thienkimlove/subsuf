<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $connection = 'mysql';
    protected $table = 'exchange';
    protected $primaryKey = 'exchange_id';
    public $timestamps = false;
}