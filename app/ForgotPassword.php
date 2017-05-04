<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    protected $connection = 'mysql';
    protected $table = 'forgot_password';
    protected $primaryKey = 'account_id';
    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo('App\Account', 'account_id', 'account_id');
    }


}