<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $connection = 'mysql';
    protected $table = 'account';
    protected $primaryKey = 'account_id';
    protected $hidden = ['password'];
    public $timestamps = false;

    /**
     * Get the account introduced of the current account.
     */
    public function account()
    {
        return $this->belongsTo('App\Account', 'from_account_id')
            ->select('account_id', 'email', 'phone_number');
    }

    /**
     * Get the payment cards info of the account
     */
    public function payment_cards()
    {
        return $this->hasMany('App\PaymentCardInfo', 'account_id');
    }

    /**
     * Get the payment cards info of the account
     */
    public function paypals()
    {
        return $this->hasMany('App\PayPalInfo', 'account_id');
    }

    /**
     * Get the orders of Account
     */
    public function orders()
    {
        return $this->hasMany('App\Order', 'shopper_id');
    }

    /**
     * Get Notifications
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification', 'to_user_id');
    }
    public function rate()
    {
        return $this->hasMany('App\AccountRate', 'account_id');
    }
}