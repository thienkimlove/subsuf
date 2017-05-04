<?php

namespace App\Http\Middleware;

use Closure;

class FunctionMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $function_slug)
    {
        $authorities = $request->session()->get('authorities');
        $module_slug = $request->get('module_slug');
        foreach ($authorities as $auth) {
            if (isset($auth->module_slug) && $auth->module_slug == $module_slug) {
                if (isset($auth->function_slug) && $auth->function_slug == $function_slug) {
                    $request->merge(["function_slug" => $function_slug]);
                    return $next($request);
                }
            }
        }

        return redirect()->action('Admin\AccessController@denied');
    }

}
