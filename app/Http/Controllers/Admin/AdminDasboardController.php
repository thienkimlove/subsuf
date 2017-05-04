<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AdminDasboardController extends Controller
{
    public function index()
    {
        $a = 1;

        $aaaa = 2;
        $response = [
            'title' => 'Trang chủ'
        ];
        return Redirect::action("Admin\StatisticsController@revenue");
        return view('admin.dasboards.index', $response);
    }
}
