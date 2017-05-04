<?php

namespace App\Http\Controllers\Frontend;

use App\Coupon;
use App\Exchange;
use App\Helper\MessageHelper;
use App\Helper\NL_Checkout;
use App\Helper\UrlHelper;
use App\Http\Controllers\Controller;
use App\NLTransaction;
use App\Notification;
use App\Offer;
use App\Order;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ExchangeRepository;
use App\Repositories\FrontendLoginRepository;
use App\Repositories\ItemRepository;
use App\Repositories\LocationRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OrderRepository;
use App\Transaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;


class ShopperController extends Controller
{
    use \App\Traits\CaptchaTrait;
    private $notification;

    public $request;
    public $account;
    public $category;
    public $location;
    public $brand;
    public $item;
    public $order;
    public $offer;
    public $exchange;
    public $service_percent;


    public function __construct(Request $request, FrontendLoginRepository $account, ItemRepository $item,
                                CategoryRepository $category, LocationRepository $location, BrandRepository $brand, OrderRepository $order,
                                OfferRepository $offer, NotificationRepository $notification,
                                ExchangeRepository $exchange

    )
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
        $this->notification = $notification;
        $this->exchange = $exchange;
        $this->service_percent = 0.05;
    }

    public function index()
    {
        $buy_where = $this->category->getWithWebsites()->toArray();
//        usort($buy_where, function ($a, $b) {
//            if (count($a['websites']) === count($b['websites'])) return 0;
//            return (count($a['websites']) < count($b['websites'])) ? 1 : -1;
//        });

        $where_buy = $this->location->getWithWebsites()->toArray();
        usort($where_buy, function ($a, $b) {
            if (count($a['websites']) === count($b['websites'])) return 0;
            return (count($a['websites']) < count($b['websites'])) ? 1 : -1;
        });

//        $brands = $this->brand->getAll()->toArray();
//        usort($brands, function ($a, $b) {
//            if (count($a['items']) === count($b['items'])) return 0;
//            return (count($a['items']) < count($b['items'])) ? 1 : -1;
//        });

        $query['featured'] = "featured = 1";
        $items = $this->item->getAll($query);

        $items_sale = $this->item->getAll(["is_sale = 1"]);

        $response = [
            'title' => 'Shop',
            'buy_where' => $buy_where,
            'where_buy' => $where_buy,
//            'brands' => $brands,
            'items' => $items,
            'items_sale' => $items_sale
        ];
        return view('frontend.shopper.index', $response);
    }

    public function order()
    {
        if ($this->request->has("start")) {
            $order = [];
            Session::forget("order");
            Session::forget("order2");
            if ($this->request->has("url")) {
                $url = $this->request->input("url");
                $base_url = parse_url($url);
                $data_json = UrlHelper::crawl($url);
                $order = json_decode($data_json, true);

                $order["link"] = $url;
            }
        } else {
            $data = [];
            if ($this->request->has("item")) {
                $item = $this->item->find($this->request->input("item"));
                if ($item) {
                    $data = [
                        "name" => $item->name,
                        "link" => $item->link,
                        "price" => ($item->is_sale) ? $item->price_sale : $item->price,
                        "description" => $item->description,
                        "quantity" => $this->request->input("quantity", 1),
//                        "url"=>$this->request->input("url",""),
                    ];
                    $data['images'] = [];
                    if ($item->image)
                        array_push($data['images'], $item->image);
                    foreach ($item->item_images as $item) {
                        array_push($data['images'], $item->image);
                    }
                    Session::set("order", $data);
                }
            } else {
                $data = Session::get("order");
            }
            $order = $data;
        }
        $this->request->flash();

        if (isset($order["description"]) && strlen($order["description"]) > 200) {
            $order["description"] = substr($order["description"], 0, 199);
        }

        $response = ["order" => $order];
        $response["exchangeArr"] = Exchange::all();
        return view('frontend.shopper.order', $response);
    }

    public function order2()
    {
//        var_dump($this->request->input("url"));die;
        $data = $this->request->all();
        if (!empty($data)) {
            $files = $this->request->file('images', []);
            $file_count = count($files);
            $uploadcount = 0;
            $images_url = [];
            if ($this->request->has("images-link"))
                $images_url = $this->request->get("images-link");
            foreach ($files as $file) {
                $image = $this->order->uploadOrderImage($file);
                if ($image) {
                    array_push($images_url, $image);
                }
            }
            $data['images'] = $images_url;
            if (count($data['images']) < 1) {
                return Redirect::back()->withError(trans('index.image_error'));
            }
            $orderKey = str_random(5);
            if (isset($data["name"])) {
            }

            $data['link'] = $data['url'];

            Session::set("order", $data);
        }
        if (!Session::has("userFrontend")) {
            Session::set("url_callback", URL::action("Frontend\ShopperController@order"));
            return Redirect::action("Frontend\LoginController@login");
        }

        $order = Session::get("order");
        $order2 = Session::get("order2");

        $this->request->flash();
        $reward1 = (int)$order["price"] * $order["quantity"] * 0.05;
        if ($reward1 > 5) {
            $reward2 = (int)$order["price"] * $order["quantity"] * 0.1;
            $reward3 = (int)$order["price"] * $order["quantity"] * 0.15;
        } else {
            $reward1 = 5;
            $reward2 = 10;
            $reward3 = 15;
            $response["isFixReward"] = 1;
        }
        $response["reward"] = [$reward1, $reward2, $reward3];
        $response["order2"] = $order2;
        $response["order"] = $order;
        $location = $this->location->getAll();
        $countrySelect = [null => "Điểm xuất phát"];
        $proviceSelect = [null => "Điểm đến"];
        foreach ($location as $item) {
            if ($item->type == 1)
                $proviceSelect[$item->location_id] = $item->name;
            else
                $countrySelect[$item->location_id] = $item->name;
        }
        $response["country"] = $countrySelect;
        $response["province"] = $proviceSelect;

        return view('frontend.shopper.order2', $response);
    }

    public function order3()
    {
        $data = $this->request->all();
        Session::set("order2", $data);
        $order = Session::get("order");
        $order2 = Session::get("order2");
        $response["order"] = $order;
        $response["order2"] = $order2;
        $response["deliver_from"] = null;
        if ((isset($order2["deliver_from"])))
            $response["deliver_from"] = $this->location->find($order2["deliver_from"]);
        $response["deliver_to"] = $this->location->find($order2["deliver_to"]);
        $response["order2"] = $order2;
        $total = round((float)$order["price"] * (int)$order["quantity"] + (float)$order2["input-reward"], 2);
        $response["fee"] = round($total * get_service_percent($total), 2);
        $response["total"] = $total + $response["fee"];
        return view('frontend.shopper.order3', $response);

    }

    public function saveOrder()
    {
        $order = Session::get("order");
        $order2 = Session::get("order2");
        $order3 = $this->request->all();
        $order_id = $this->order->saveOrder(Session::get("userFrontend")["account_id"], $order, $order2, $order3);
        Session::forget("order1");
        Session::forget("order2");
        return Redirect::action('Frontend\ShopperController@orderDetail', $order_id)->withSuccess(trans("index.taoorderthanhcong"));
    }

    // chi tiết order
    public function orderDetail($id)
    {
        if ($this->request->has('notification')) {
            $notification_id = (int)$this->request->input('notification');
            Notification::where('notification_id', $notification_id)->update(['is_read' => 1]);
        }
        $order = $this->order->find($id);
        if (!$order) {
            abort(404);
        }
        if ($order->order_status == 2 || $order->order_status == 3) {
            $offer = Offer::where("order_id", $id)->where("offer_status", ">", 1)->first();
            if (Session::has("userFrontend")) {
                $account_id = Session::get("userFrontend")["account_id"];
                $isShopper = false;
                $isTraveler = false;
                if ($account_id == $order->shopper_id)
                    $isShopper = true;
                else if (isset($offer) && $account_id == $offer->traveler_id)
                    $isTraveler = true;
                else {
                    return Redirect::action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
                }
            } else {
                return Redirect::action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
            }
            $transaction = Transaction::where("offer_id", $offer->offer_id)->first();
            $response = [
                "order" => $order,
                "offer" => $offer,
                "isShopper" => $isShopper,
                "isTraveler" => $isTraveler,
                "exchange" => $this->exchange->change("USD", "VND"),
                "transaction" => $transaction,
            ];
            return view('frontend.shopper.transaction_detail', $response);
        }
        $response = [
            "order" => $order,
            "exchange" => $this->exchange->change("USD", "VND"),
            "offer" => Offer::where("order_id", $id)->where("offer_status", 1)->get(),
            "isOffer" => (Session::has("userFrontend")) ? Offer::where("order_id", $id)->where("traveler_id", Session::get("userFrontend")["account_id"])->count() : false
        ];

        return view('frontend.shopper.order_detail', $response);
    }


    public function deactiveOrder($order_id)
    {
        $order = Order::where("order_id", $order_id)->where("order_status", 1)->first();
        if (!$order) {
            return Redirect::action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        if ($order->shopper_id != Session::get("userFrontend")["account_id"]) {
            return Redirect::action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.bankhongphaichumonhang"));
        }
        $order->order_status = -1;
        $order->save();
        $offer = Offer::where("order_id", $order_id)->delete();
        return Redirect::action("Frontend\ShopperController@orderDetail", $order_id)->withSuccess(trans("index.datatorder"));
    }

    public function activeOrder($order_id)
    {
        if ($this->request->has('notification')) {
            $notification_id = (int)$this->request->input('notification');
            Notification::where('notification_id', $notification_id)->update(['is_read' => 1]);
        }
        $order = Order::where("order_id", $order_id)->where("order_status", -1)->first();
        if (!$order) {
            return Redirect::action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        if ($order->shopper_id != Session::get("userFrontend")["account_id"]) {
            return Redirect::action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.bankhongphaichumonhang"));
        }
        $order->order_status = 1;
        $order->save();
    }
}