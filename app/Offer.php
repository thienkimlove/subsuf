<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $connection = 'mysql';
    protected $table = 'offers';
    protected $primaryKey = 'offer_id';
    public $timestamps = false;

    /**
     * Get owner of offer
     */
    public function account()
    {
        return $this->belongsTo('App\Account', 'traveler_id', 'account_id')
            ->select(['account_id', 'first_name', 'last_name', 'email', 'avatar', 'phone_number']);
    }

    /**
     * Get from location
     */
    public function from_location()
    {
        return $this->hasOne('App\Location', 'location_id', 'deliver_from');
    }

    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}