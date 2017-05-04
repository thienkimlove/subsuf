<?php

namespace App\Http\Middleware;

use Closure;

class ModuleMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module_slug)
    {
        $authorities = $request->session()->get('authorities');
        foreach ($authorities as $auth) {
            if (isset($auth->module_slug) && $auth->module_slug == $module_slug) {
                $request->merge(["module_slug" => $module_slug]);
                return $next($request);
            }
        }

        return redirect()->action('Admin\AccessController@denied');
    }

}
