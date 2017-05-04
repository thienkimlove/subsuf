<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Notification;
use App\Repositories\BlogRepository;
use App\Repositories\BlogCategoryRepository;
use Symfony\Component\HttpFoundation\Request;


class TestController extends Controller
{
    private $request;
    private $blog;
    private $category;
    private $locale;

    public function __construct(Request $request, BlogRepository $blog, BlogCategoryRepository $category)
    {
        parent::__construct();
        $this->request = $request;
        $this->blog = $blog;
        $this->category = $category;

        $this->locale = \App::getLocale();
        if ($this->locale == '') {
            $this->locale = 'vi';
        }
    }

    public function index()
    {
        $notification = Notification::find(30);
        $offers = $notification->order->offers;
        foreach ($offers as $item){
        }
//        $param["reward"]=$offer->shipping_fee+$offer->others_fee+$offer->tax;
//        var_dump($offer);die;
        send_mail($notification, 'accept_offer');
    }

}
