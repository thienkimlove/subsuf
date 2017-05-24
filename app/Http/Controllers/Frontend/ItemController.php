<?php

namespace App\Http\Controllers\Frontend;

use App\Coupon;
use App\Helper\NL_Checkout;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Order;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FrontendLoginRepository;
use App\Repositories\ItemRepository;
use App\Repositories\LocationRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OrderRepository;
use App\Transaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends Controller
{
    public function __construct(Request $request, FrontendLoginRepository $account, ItemRepository $item,
                                CategoryRepository $category, LocationRepository $location, BrandRepository $brand, OrderRepository $order,
                                OfferRepository $offer)
    {
        parent::__construct();
        $this->request = $request;
        $this->account = $account;
        $this->category = $category;
        $this->location = $location;
        $this->brand = $brand;
        $this->item = $item;
        $this->order = $order;
        $this->offer = $offer;
        $this->service_percent = 0.05;
    }

    public function item($item_id)
    {
        $item = $this->item->find($item_id);
        if (!$item) {
            abort(404);
        }
        $response = [
            'title' => trans("index.sanpham"),
            'item' => $item
        ];
      //  return view('frontend.item.item', $response);

        return view('v2.item.item', $response);
    }

    public function test()
    {
        return view('frontend.layout.404');
    }


}
