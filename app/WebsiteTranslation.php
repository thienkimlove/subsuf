<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
