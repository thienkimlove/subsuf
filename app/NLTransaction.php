<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class NLTransaction extends Model
{
    protected $connection = 'mysql';
    protected $table = 'nl_transaction';
    protected $primaryKey = 'id';
    public $timestamps = false;
}