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
use CouponHelper;
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


        $where_buy = $this->location->getWithWebsites()->toArray();
        usort($where_buy, function ($a, $b) {
            if (count($a['websites']) === count($b['websites'])) return 0;
            return (count($a['websites']) < count($b['websites'])) ? 1 : -1;
        });


        $query['featured'] = "featured = 1";
        $items = $this->item->getAll($query);

        $items_sale = $this->item->getAll(["is_sale = 1"]);

        $response = [
            'title' => 'Shop',
            'buy_where' => $buy_where,
            'where_buy' => $where_buy,
            'items' => $items,
            'items_sale' => $items_sale
        ];
        return view('frontend.shopper.index', $response);
    }

    public function order()
    {
        if ($this->request->has("start")) {
            $order = [];
            session()->forget("order");
            session()->forget("order2");
            if ($this->request->has("url")) {
                $url = $this->request->input("url");
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
                        "quantity" => $this->request->input("quantity", 1)
                    ];
                    $data['images'] = [];
                    if ($item->image) {
                        array_push($data['images'], $item->image);
                    }
                    foreach ($item->item_images as $item) {
                        array_push($data['images'], $item->image);
                    }
                    session()->put("order", $data);
                }
            } else {
                $data = session()->get("order");
            }
            $order = $data;
        }
        $this->request->flash();

        if (isset($order["description"]) && strlen($order["description"]) > 200) {
            $order["description"] = substr($order["description"], 0, 199);
        }

        $response = ["order" => $order];
       // return view('frontend.shopper.order', $response);

        return view('v2.shopper.order', $response);
    }

    public function order2()
    {

        $validator = Validator::make($this->request->all(), [
            'price' => 'numeric|max:9999999',
            'quantity' => 'numeric|max:999',
        ], [
                "price.max" => trans("index.sotiennhapvaoqualon"),
                "price.numeric" => "Input False!",
                "quantity.max" => trans("index.soluongnhapvaoqualon"),
                "quantity.numeric" => "Input false!",
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withError($validator->errors()->first());
        }
        $data = $this->request->all();
        if (!empty($data)) {
            $files = $this->request->file('images', []);           
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
                return  redirect()->back()->withError(trans('index.image_error'));
            }
            
            $data['link'] = $data['url'];

            session()->put("order", $data);
        }
        if (!session()->has("userFrontend")) {
            session()->put("url_callback", URL::action("Frontend\ShopperController@order"));
            return redirect()->action("Frontend\LoginController@login");
        }

        $order = session()->get("order");
        $order2 = session()->get("order2");

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
        $provinceSelect = [null => "Điểm đến"];
        foreach ($location as $item) {
            if ($item->type == 1)
                $provinceSelect[$item->location_id] = $item->name;
            else
                $provinceSelect[$item->location_id] = $item->name;
        }
        $response["country"] = $countrySelect;
        $response["province"] = $provinceSelect;

        //return view('frontend.shopper.order2', $response);

        return view('v2.shopper.order2', $response);
    }

    public function order3()
    {
        $data = $this->request->all();
        session()->put("order2", $data);
        $order = session()->get("order");
        $order2 = session()->get("order2");
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
        //return view('frontend.shopper.order3', $response);

        return view('v2.shopper.order3', $response);

    }

    public function saveOrder()
    {
        $order = session()->get("order");
        $order2 = session()->get("order2");
        $order3 = $this->request->all();
        $order_id = $this->order->saveOrder(session()->get("userFrontend")["account_id"], $order, $order2, $order3);
        session()->forget("order1");
        session()->forget("order2");
        return redirect()->action('Frontend\ShopperController@orderDetail', $order_id)->withSuccess(trans("index.taoorderthanhcong"));
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
            if (session()->has("userFrontend")) {
                $account_id = session()->get("userFrontend")["account_id"];
                $isShopper = false;
                $isTraveler = false;
                if ($account_id == $order->shopper_id)
                    $isShopper = true;
                else if (isset($offer) && $account_id == $offer->traveler_id)
                    $isTraveler = true;
                else {
                    return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
                }
            } else {
                return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
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
            "isOffer" => (session()->has("userFrontend")) ? Offer::where("order_id", $id)->where("traveler_id", session()->get("userFrontend")["account_id"])->count() : false
        ];

        //return view('frontend.shopper.order_detail', $response);

        return view('v2.shopper.order_detail', $response);
    }


    public function deactiveOrder($order_id)
    {
        $order = Order::where("order_id", $order_id)->where("order_status", 1)->first();
        if (!$order) {
            return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        if ($order->shopper_id != session()->get("userFrontend")["account_id"]) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.bankhongphaichumonhang"));
        }
        $order->order_status = -1;
        $order->save();
        Offer::where("order_id", $order_id)->delete();
        return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withSuccess(trans("index.datatorder"));
    }

    public function activeOrder($order_id)
    {
        if ($this->request->has('notification')) {
            $notification_id = (int)$this->request->input('notification');
            Notification::where('notification_id', $notification_id)->update(['is_read' => 1]);
        }
        $order = Order::where("order_id", $order_id)->where("order_status", -1)->first();
        if (!$order) {
            return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        if ($order->shopper_id != session()->get("userFrontend")["account_id"]) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.bankhongphaichumonhang"));
        }
        $order->order_status = 1;
        $order->save();
        Offer::where("order_id", $order_id)->delete();
        return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withSuccess(trans("index.dabatorder"));
    }

    public function acceptOffer($offer_id)
    {

        $offer = Offer::find($offer_id);
        if (!$offer) {
            return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        $order = Order::find($offer->order_id);
        if ($offer->offer_status > 1)
            return redirect()->action("Frontend\ShopperController@orderDetail", $order->order_id);
        $total = round((float)$order->price * $order->quantity + $offer->shipping_fee + $offer->tax + $offer->others_fee, 2);
        $fee = round($total * get_service_percent($total), 2);


        $coupons = Coupon::where("account_id", session()->get("userFrontend")["account_id"])
            ->where("money", "<=", $total)
            ->where("status", 1)
            ->get();

        $absoluteTotal = $total+$fee;

        foreach ($coupons as &$coupon) {
            $coupon->amount_be_coupon = CouponHelper::getRealCouponAmountByTotal($absoluteTotal, $coupon->money, $coupon->type, $coupon->primary_percent, $coupon->secondary_percent);
        }


        $response = [
            "offer" => $offer,
            "order" => $order,
            "total" => $total,
            "exchange" => $this->exchange->change("USD", "VND"),
            "fee" => $fee,
            "coupon" => $coupons // các coupon của user
        ];
        return view('frontend.shopper.accept_offer', $response);
    }

    public function saveAcceptOffer($account_id, $offer_id, $coupon_id)
    {
        if ($this->request->has('payment_id')) {
//        if (isset($this->request->input('payment_id'])) {
            // Lấy các tham số để chuyển sang Ngânlượng thanh toán:
            $transaction_info = $this->request->input('transaction_info');
            $order_code = $this->request->input('order_code');
            $price = $this->request->input('price');
            $payment_id = $this->request->input('payment_id');
            $payment_type = $this->request->input('payment_type');
            $error_text = $this->request->input('error_text');
            $secure_code = $this->request->input('secure_code');
            $exchange = $this->exchange->change("USD", "VND");
//            if ($exchange == 0) {
//                return redirect()->back()->withError(trans("index.khongquydoiduoctigia"));
//            }
//            $exchangePrice = $exchange * $price;
            // kiểm tra xem có phải đang test ko
            if ($this->request->has("testpay")) {
                $checkpay = true;
            } else {
                //Khai báo đối tượng của lớp NL_Checkout
                $nl = new NL_Checkout();
                $nl->merchant_site_code = config('app.MERCHANT_ID');
                $nl->secure_pass = config('app.MERCHANT_PASS');
                //Tạo link thanh toán đến nganluong.vn
                $checkpay = $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);
            }
            try {
                $data = [
                    'payment_id' => $payment_id,
                    'transaction_info' => $transaction_info,
                    'order_code' => $order_code,
                    'price' => $price,
                    'payment_type' => $payment_type,
                    'error_text' => $error_text,
                    'secure_code' => $secure_code,
                    'checkpay' => $checkpay,
                ];

                NLTransaction::insert($data);
            } catch (\Exception $e) {
            }

            if ($checkpay) {
//                $account_id = session()->get("userFrontend")["account_id"];
                $date = date("Y-m-d H:i:s");
                $offer = Offer::find($offer_id);
                if (!$offer) {
                    return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinoffer"));
                }
                if ($offer->offer_status != 1) {
                    return redirect()->action("Frontend\ShopperController@orderDetail", $offer->order_id);
//                    return redirect()->action("Frontend\IndexController@error")->withError(trans("index.offerdahethan"));
                }
                $order = $offer->order;
                if ($order->shopper_id != $account_id) {
                    return redirect()->action("Frontend\ShopperController@orderDetail", $offer->order_id)->withError("Lỗi");
                }
                Offer::where("order_id", $order->order_id)->update(["offer_status" => -1]);
                $offer->offer_status = 2;
                $offer->save();

                $order->order_status = 2;
                $order->save();

                Offer::where("order_id", $order->order_id)->where("offer_id", "!=", $offer->offer_id)->delete();

                $transaction = new Transaction();
                $transaction->offer_id = $offer->offer_id;
                $transaction->coupon_id = 0;

                if ($offer->payment_type == "bank")
                    $payment_id = $offer->payment_info_id;
                else {
                    $payment_id = $offer->payment_info_id;
                }
                $total_order = (float)$order->price * $order->quantity +
                    $offer->shipping_fee + $offer->tax + $offer->others_fee;

                $transaction->service_fee = round($total_order * get_service_percent($total_order), 2);

                //new way to process with coupon.
                $amount_be_coupon = 0;
                $absoluteTotal = $total_order * (1 + get_service_percent($total_order));

                $coupon = Coupon::whereIn("account_id", [$account_id, 0])
                    ->where("amount", ">", 0)
                    ->where("coupon_id", $coupon_id)->where("status", 1)->get();

                if ($coupon->count() > 0) {
                    $coupon = $coupon->first();
                    $transaction->coupon_id = $coupon_id;
                    $coupon->amount = (int)$coupon->amount - 1;
                    if (!$coupon->amount) {
                        $coupon->status = -1; // đã dùng
                    } else {
                        $coupon->used_at = $date;
                        $coupon_money = $coupon->money;
                        $coupon_type = $coupon->type;
                        $coupon_primary_percent = $coupon->primary_percent;
                        $coupon_secondary_percent = $coupon->secondary_percent;

                        $amount_be_coupon = CouponHelper::getRealCouponAmountByTotal($absoluteTotal, $coupon_money, $coupon_type, $coupon_primary_percent, $coupon_secondary_percent);
                        $coupon->real_money = $amount_be_coupon;
                    }
                    $coupon->save();
                }

                $transaction->total = round($absoluteTotal - $amount_be_coupon, 2);
                $transaction->transaction_time = $date;
                $transaction->transaction_date = $date;
                $transaction->transaction_date = $date;
                $transaction->payment_type = $offer->payment_type;
                $transaction->payment_id = $payment_id;
                $transaction->exchange = $exchange;
                $transaction->transaction_status = 2; // đang giao dịch
                $transaction->save();

                try {
                    //Create Accept Offer Notification
                    $data = get_notification($order, $offer, MessageHelper::accept_offer(), MessageHelper::accept_offer('en'), 'accept_offer');
//                echo \GuzzleHttp\json_encode($data);die;
                    $notification_id = $this->notification->insert($data);
                    $notification = $this->notification->find($notification_id);
                    //send mail
                    send_mail($notification, 'accept_offer');
                } catch (\Exception $e) {
                }

                try {
                    //Create Payment Success Notification
                    $data = get_notification($order, $offer,
                        MessageHelper::payment_success(), MessageHelper::payment_success('en'), 'payment_success');
//                echo \GuzzleHttp\json_encode($data);die;
                    $notification_id = $this->notification->insert($data);
                    $notification = $this->notification->find($notification_id);

                    //send mail
                    send_mail($notification, 'payment_success');
                } catch (\Exception $e) {
                }

                return redirect()->action("Frontend\ShopperController@orderDetail", $offer->order_id)->withSuccess(trans("index.nhanbofferthanhcong"));
            } else {
                return redirect()->action('Frontend\ShopperController@acceptOffer', $offer_id)
                    ->withError(trans("index.thanhtoanthatbai"));
            }
        } else {
            return redirect()->action('Frontend\ShopperController@acceptOffer', $offer_id)
                ->withError(trans("index.khongcothongtinthanhtoan"));
        }
    }

    public function deleteTransaction($order_id)
    {
        $order = Order::where("order_id", $order_id)->first();
        if (!$order) {
            return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinoffer"));
        }
        if ($order->order_status == 3) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.daxacnhannhanhang"));
        }
        if ($order->order_status != 2) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.banchuaxacnhanoffernao"));
        }

        $offer = Offer::where("order_id", $order_id)->first();
        if (session()->has("userFrontend")) {
            $account_id = session()->get("userFrontend")["account_id"];
//            if (!($account_id == $order->shopper_id || $account_id == $offer->traveler_id)) {
            if (!($account_id == $offer->traveler_id)) {
                abort(404);
                return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
            }
        } else {
            abort(404);
            return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        $order->order_status = 1;
        $order->save();
        $offer->offer_status = -1;
        $offer->save();
        $transaction = Transaction::where("offer_id", $offer->offer_id)->first();
        if ($transaction) {
            $transaction->transaction_status = -1;
            $transaction->save();
        }

        try {
            //Create Cancel Offer Notification
            $data = get_notification($order, $offer, MessageHelper::cancel_offer(), MessageHelper::cancel_offer('en'), 'cancel_offer');
//                echo \GuzzleHttp\json_encode($data);die;
            $notification_id = $this->notification->insert($data);
            $notification = $this->notification->find($notification_id);
            //send mail
            send_mail($notification, 'cancel_offer');
        } catch (\Exception $e) {
        }

        return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withSuccess(trans("index.daxoagg"));
    }

    public function finishOrder($order_id)
    {
        $params = $this->request->all();
//        $params['captcha'] = $this->captchaCheck();

        $validator = Validator::make($params, [
//            'g-recaptcha-response' => 'required',
            'captcha' => 'required|captcha',
        ], [
//            'g-recaptcha-response.required' => 'Yêu cầu nhập Captcha',
//            'captcha.min' => 'Sai Captcha. Vui lòng thử lại'
            'captcha.required' => trans('index.captcha_required'),
            'captcha.captcha' => trans('index.captcha_failed'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withError($validator->errors()->first());
        }

//        $code = $this->request->input('captcha');
//
//        // Validation failed
//        if (!(new Captcha)->validate($code)) {
//            return redirect()->back()->withError(trans('index.captcha_failed'));
//        }
        $order = Order::where("shopper_id", session()->get("userFrontend")["account_id"])->where("order_id", $order_id)->first();
        if (!$order) {
            return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        if ($order->order_status == 3) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.daxacnhannhanhang"));
        }
        if ($order->order_status != 2) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.banchuaxacnhanoffernao"));
        }
        if(Offer::where("order_id", $order_id)->where("offer_status",2)->count()>1){
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError("System Error!!! Please contact us now!");
        }

        $offer = Offer::where("order_id", $order_id)->where("offer_status",2)->first();
        if (session()->has("userFrontend")) {
            $account_id = session()->get("userFrontend")["account_id"];
            if (!($account_id == $order->shopper_id || $account_id == $offer->traveler_id)) {
                return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
            }
        } else {
            return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        $order->order_status = 3;
        $order->received_time = date("Y-m-d H:i:s");
        if ($offer) {
            $offer->offer_status = 3;
            $offer->save();
            $transaction = Transaction::where("offer_id", $offer->offer_id)->first();
            if ($transaction) {
                $transaction->received_time = date("Y-m-d H:i:s");
                $transaction->transaction_status = 3;
                $transaction->save();
            }
//            if ($offer->offer_status == 3) {
//                $transaction = Transaction::where("offer_id", $offer->offer_id)->first();
//                if ($transaction) {
//                    $transaction->received_time = date("Y-m-d H:i:s");
//                    $transaction->transaction_status = 3;
//                    $transaction->save();
//                }
//            }
        }

        $order->save();

        try {
            //Create Shopper Received Order to Traveler Notification
            $data = get_notification($order, $offer,
                MessageHelper::shopper_received(), MessageHelper::shopper_received('en'), 'shopper_received');
//                echo \GuzzleHttp\json_encode($data);die;
            $notification_id = $this->notification->insert($data);
            $notification = $this->notification->find($notification_id);

            //send mail
            send_mail($notification, 'shopper_received');
        } catch (\Exception $e) {
        }

        return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withSuccess(trans("index.daxacnhannhanhang"));
    }

    public function editOrder($order_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        if ($order->shopper_id != session()->get("userFrontend")["account_id"]) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.bankhongphaichumonhang"));
        }
        if ($order->order_status > 1) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.orderdangduocggkhongthesua"));
        }

        $response = ["order" => $order];

        $reward1 = (int)$order["price"] * $order["quantity"] * 0.05;
        if ($reward1 > 5) {
            $reward2 = (int)$order["price"] * $order["quantity"] * 0.1;
            $reward3 = (int)$order["price"] * $order["quantity"] * 0.15;
        } else {
            $reward1 = 5;
            $reward2 = 10;
            $reward3 = 15;
        }
        $response["reward"] = [$reward1, $reward2, $reward3];
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
        $response["exchangeArr"] = Exchange::all();

        return view('frontend.shopper.edit_order', $response);

    }

    public function doEditOrder($order_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return redirect()->action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        if ($order->shopper_id != session()->get("userFrontend")["account_id"]) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.bankhongphaichumonhang"));
        }
        if ($order->order_status > 1) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withError(trans("index.orderdangduocggkhongthesua"));
        }
        if ($this->order->editOrder($order_id, $this->request)) {
            return redirect()->action("Frontend\ShopperController@orderDetail", $order_id)->withSuccess(trans("index.suathanhcong"));
        } else {
            return redirect()->back()->withError(trans('index.image_error'));
        }
    }

    public function addCouponCode()
    {
        $data = [
            "status" => 0,
            "message" => "Mã coupon không đúng",
        ];
        if (!session()->has("userFrontend")) {
            return response($data);
        }
        $couponCode = $this->request->input("coupon");
        $total = (float)$this->request->input("total");
        $code = Coupon::where("coupon_code", $couponCode)
            ->where("account_id", 0)
            ->where("amount", ">", 0)
            ->where("status", 1)
            ->first();
        if ($code) {
            if ($code->promotion_email && session()->get("userFrontend")["email"] != $code->promotion_email) {
                $data = [
                    "status" => 0,
                    "message" => "Mã coupon không đúng email!",
                ];
            } else if ($code->money <= $total) {

                $amount_be_coupon = CouponHelper::getRealCouponAmountByTotal($total, $code->money, $code->type, $code->primary_percent, $code->secondary_percent);
                $responseData = $code->toArray();
                $responseData['amount_be_coupon'] = $amount_be_coupon;

                $data = [
                    "status" => 1,
                    "data" => $responseData,
                ];
            } else {
                $data = [
                    "status" => 0,
                    "message" => "Mã coupon đã hết hạn",
                ];
            }

        }
        return response($data);
    }
}
