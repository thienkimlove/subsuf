<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}