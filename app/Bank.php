<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = 'mysql';
    protected $table = 'bank';
    protected $primaryKey = 'bank_id';
    public $timestamps = false;

    /**
     * Get the role record associated with the admin.
     */
    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id');
    }
}