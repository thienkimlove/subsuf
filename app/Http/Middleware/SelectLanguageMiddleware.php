<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 11/9/2016
 * Time: 11:04 PM
 */

namespace App\Http\Middleware;

use App;
use Closure;

use Config;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Session;

class SelectLanguageMiddleware
{
    public function __construct(Application $app, Redirector $redirector, Request $request)
    {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Make sure current locale exists.
        $languages = Config::get('app.locales', []);

        if (Session::has('app_locale') && array_key_exists(Session::get('app_locale'), $languages)) {
            App::setLocale(Session::get('app_locale'));
        } else {
            App::setLocale(Config::get('app.fallback_locale'));
        }

        return $next($request);
    }
}