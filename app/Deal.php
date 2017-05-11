<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use Translatable;
    public $translatedAttributes = ['title', 'desc'];
    public $translationModel = 'App\DealTranslation';
}
