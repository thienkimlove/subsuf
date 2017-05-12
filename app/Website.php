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

class Website extends Model
{

    use Translatable;
    public $translatedAttributes = ['name', 'description'];
    public $translationModel = 'App\WebsiteTranslation';

    protected $connection = 'mysql';
    protected $table = 'website';
    protected $primaryKey = 'website_id';
    public $timestamps = false;

    public function nation()
    {
        return $this->belongsTo('App\Location', 'location_id')
            ->select(['location_id', 'name']);
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id')
            ->select(['category_id', 'name']);
    }
}