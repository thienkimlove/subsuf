<?php

namespace App\Http\Middleware;

use Closure;

class RightMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $right)
    {
        $authorities = $request->session()->get('authorities');
        $module_slug = $request->get('module_slug');
        $function_slug = $request->get('function_slug');

        foreach ($authorities as $auth) {
            if (isset($auth->module_slug) && $auth->module_slug == $module_slug) {
                if (isset($auth->function_slug) && $auth->function_slug == $function_slug) {
                    if (isset($auth->pivot) && $auth->pivot[$right] == 1) {
                        return $next($request);
                    }
                }
            }
        }

        return redirect()->action('Admin\AccessController@denied');
    }

}
