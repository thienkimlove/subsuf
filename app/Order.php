<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mysql';
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable = [];
    /**
     * Get images of Order
     */
    public function order_images()
    {
        return $this->hasMany('App\OrderImage', 'order_id');
    }

    /**
     * Get owner of Order
     */
    public function account()
    {
        return $this->belongsTo('App\Account', 'shopper_id', 'account_id')
            ->select(['account_id', 'first_name', 'last_name', 'email', 'avatar', 'phone_number']);
    }

    /**
     * Get to location
     */
    public function to_location()
    {
        return $this->hasOne('App\Location', 'location_id', 'deliver_to');
    }

    /**
     * Get from location
     */
    public function from_location()
    {
        return $this->hasOne('App\Location', 'location_id', 'deliver_from');
    }

    /**
     * Get offers
     */
    public function offers()
    {
        return $this->hasMany('App\Offer', 'order_id');
    }
}