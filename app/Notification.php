<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $connection = 'mysql';
    protected $table = 'notification';
    protected $primaryKey = 'notification_id';

    public function getDates()
    {
        return ['created_at', 'updated_at', 'sent_at'];
    }

    public function from_user()
    {
        return $this->belongsTo('App\Account', 'from_user_id', 'account_id')
            ->select(['account_id', 'first_name', 'last_name', 'avatar', 'email', 'phone_number']);
    }

    public function to_user()
    {
        return $this->belongsTo('App\Account', 'to_user_id', 'account_id')
            ->select(['account_id', 'first_name', 'last_name', 'avatar', 'email', 'phone_number']);
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', 0);
    }
}