<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 11/22/2016
 * Time: 4:32 PM
 */

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use LaravelCaptcha\Lib\Captcha;

class CaptchaController extends Controller
{
    public function index(Captcha $captcha)
    {
        echo "sfdghjhgfd"; die;
        var_dump(Session::get("captcha"));die;
        $captcha->get();
    }

    public function html(Captcha $captcha)
    {
        return $captcha->html();
    }
}