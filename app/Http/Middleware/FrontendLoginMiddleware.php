<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class FrontendLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('userFrontend')) {
//            $urlPrev = URL::previous();
//            $data = $request->all();
//            var_dump($data);die;
//            if (isset($data["isorder"])) {
//                    $files = $request->file('images', []);
//                    $file_count = count($files);
//                    $uploadcount = 0;
//                    $images_url = [];
//                    if ($request->has("images-link"))
//                        $images_url = $request->get("images-link");
//                    foreach ($files as $file) {
//                        $rules = array('file' => 'required|mimes:png,gif,jpeg'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
//                        $validator = Validator::make(array('file' => $file), $rules);
//                        if ($validator->passes()) {
//                            $destinationPath = 'upload/order/' . date("ym") . "/";
//                            $filename = $file->getClientOriginalName();
//                            $upload_success = $file->move($destinationPath, $filename);
//                            $uploadcount++;
//                            array_push($images_url, $destinationPath . $filename);
//                        } else {
//                        }
//                    }
//                    $data['images'] = $images_url;
//                    $orderKey = str_random(5);
//                    if (isset($data["name"])) {
//                        Session::set("order", $data);
//                    }
//                Session::set("url_calback", $urlPrev);
//            } else
//                if (isset($data["isoffer"])) {
//                    Session::set("offer", $data);
//                    Session::set("url_calback", $urlPrev);
//                }
            return redirect()->action('Frontend\LoginController@login');
        }
        return $next($request);
    }
}
