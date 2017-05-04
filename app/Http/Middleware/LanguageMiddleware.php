<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 11/9/2016
 * Time: 11:04 PM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class LanguageMiddleware
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
        $locale = \Cookie::get('selected_language');
        if ($locale == null) {
            return \Redirect::action('Frontend\IndexController@select_language');
        }

        return $next($request);
    }
}