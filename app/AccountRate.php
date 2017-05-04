<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountRate extends Model
{
    protected $connection = 'mysql';
    protected $table = 'account_rate';
    protected $primaryKey = 'account_rate_id' ;

    public function getDates()
    {
        return ['time_rate'];
    }

    public function user()
    {
        return $this->belongsTo('App\Account', 'account_id', 'account_id')
            ->select(['account_id', 'first_name', 'last_name', 'avatar', 'email', 'phone_number']);
    }
    public function user_rate()
    {
        return $this->belongsTo('App\Account', 'account_rate');
    }
}