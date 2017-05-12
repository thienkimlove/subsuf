<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/13/2016
 * Time: 11:43 PM
 */

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use Translatable;
    public $translatedAttributes = ['name'];
    public $translationModel = 'App\LocationTranslation';

    protected $connection = 'mysql';
    protected $table = 'location';
    protected $primaryKey = 'location_id';
    public $timestamps = false;

    public function websites()
    {
        return $this->hasMany('App\Website', 'location_id');
    }
}