<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\MessageHelper;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Order;
use App\PaymentCardInfo;
use App\PayPalInfo;
use App\Repositories\LocationRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Transaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;


class TravelerController extends Controller
{
    public function __construct(Request $request, OrderRepository $order = null, LocationRepository $location = null,
                                NotificationRepository $notification)
    {
        parent::__construct();
        $this->request = $request;
        $this->order = $order;
        $this->location = $location;
        $this->notification = $notification;
        $this->account_id = Session::get("userFrontend")["account_id"];
    }

    public function index()
    {
        $response = [
            'title' => 'Travel'
        ];
        $country = $this->location->getAll();
        $countrySelect = [];

        $countrySelect[null] = trans('index.diemxuatphat_select');
        $proviceSelect = [];
        $proviceSelect[null] =  trans('index.diemden_select');
        foreach ($country as $item) {
            if ($item->type == 1)
                $proviceSelect[$item->location_id] = $item->name;
            else
                $countrySelect[$item->location_id] = $item->name;
        }


        $response["country"] = $countrySelect;
        $response["province"] = $proviceSelect;
//        $response['orderList'] = Order::where("order_status", 1)->where("request_time", ">=", date("Y-m-d H:i:s", strtotime("-30 days")))->orderBy("request_time", "DESC")->paginate(30);
        $response['orderList'] = Order::where("order_status", 1)->orderBy("request_time", "DESC")->paginate(30);
        //return view('frontend.traveler.index', $response);
        return view('v2.traveler.index', $response);
    }

    public function find()
    {
        $order = Order::where("order_status", 1)->orderBy("request_time", "DESC");
        if ($this->request->has("deliver_to")) {
            if($this->request->input("deliver_to") != 9) {

                $order->where("deliver_to", (int)$this->request->input("deliver_to"));
            }
        }
        if ($this->request->has("deliver_from")) {

            if($this->request->input("deliver_from") != 9) {

                $order->where("deliver_from", (int)$this->request->input("deliver_from"));

            }
        }
        $country = $this->location->getAll();
        $countrySelect = [];

        $countrySelect[null] = trans('index.diemxuatphat_select');
        $proviceSelect = [];
        $proviceSelect[null] =  trans('index.diemden_select');
        foreach ($country as $item) {
            if ($item->type == 1)
                $proviceSelect[$item->location_id] = $item->name;
            else
                $countrySelect[$item->location_id] = $item->name;
        }
        $this->request->flash();
        $response = [
            'title' => 'Travel',
            'orderList' => $order->paginate(21),
            "country" => $countrySelect,
            "province" => $proviceSelect,
        ];
      //  return view('frontend.traveler.find', $response);

        return view('v2.traveler.find', $response);
    }

    public function offer($order_id)
    {
        if (!Session::has("userFrontend")) {
            Session::set("url_callback", URL::action("Frontend\TravelerController@offer", $order_id));
            return Redirect::action("Frontend\LoginController@login");
        }
        if (!(!Session::get("userFrontend")["phone_number"] || !Session::get("userFrontend")["email"])) {
            $cardInfo = PaymentCardInfo::where("account_id", $this->account_id)->get();
            $payPalInfo = PayPalInfo::where("account_id", $this->account_id)->get();
            if (!($cardInfo->count()) && !($payPalInfo->count())) {
                $data = $this->request->all();
                $data["url_calback"] = URL::action("Frontend\TravelerController@offer", $order_id);
                Session::set("offer", $data);
                return Redirect::action("Frontend\UserController@paymentInfo");
            }
        }

        $country = $this->location->getAll();
        $countrySelect = [];
        $proviceSelect = [];
        foreach ($country as $item) {
            if ($item->type == 1)
                $proviceSelect[$item->location_id] = $item->name;
            else
                $countrySelect[$item->location_id] = $item->name;
        }
        $response = [
            'title' => 'Travel',
            "order" => $this->order->find($order_id),
            "country" => $countrySelect,
            "province" => $proviceSelect,
            "banks" => PaymentCardInfo::where("account_id", $this->account_id)->get(),
            "paypals" => PayPalInfo::where("account_id", $this->account_id)->get(),
        ];
        //return view('frontend.traveler.offer', $response);
        return view('v2.traveler.offer', $response);
    }

    public function makeOffer($order_id)
    {
        $validator = Validator::make($this->request->all(), [
            // 'other_fee' => 'required',
            'date' => 'required',
            'deliver_from' => 'required',
            // 'payment_type' => 'required',
        ], [
            'date.required' => trans("index.banchuanhapngaygiaohang"),
            'deliver_from.required' => trans("index.banchuanhapnoimuahang"),
        ]);
        if (is_error($validator)) {
            return Redirect::action("Frontend\TravelerController@offer", $order_id)->withError($validator->errors()->first());
        }
        $cardInfo = PaymentCardInfo::where("account_id", $this->account_id)->get();
        $payPalInfo = PayPalInfo::where("account_id", $this->account_id)->get();
        if (!($cardInfo->count()) && !($payPalInfo->count())) {
            $data = $this->request->all();
            $data["url_calback"] = URL::action("Frontend\TravelerController@offer", $order_id);
            Session::set("offer", $data);
            return Redirect::action("Frontend\UserController@paymentInfo");
        }
        $payment = $this->request->input("payment_type");
        if ($payment != "paypal" && $payment != "bank") {
            return Redirect::action("Frontend\TravelerController@offer", $order_id)->withError(trans("index.khongcothongtinthanhtoan"));
        }

        $payment_info_id = 0;
        if ($this->request->has('payment_info_id')) {
            $payment_info_id = $this->request->input("payment_info_id");
        } else {
            return Redirect::action("Frontend\TravelerController@offer", $order_id)->withError(trans("index.khongcothongtinthanhtoan"));
        }

        $order = Order::find($order_id);

        if (!$order) {
            return Redirect::action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinorder"));
        }
        $isOffered = Offer::where("order_id", $order->order_id)->where("traveler_id", $this->account_id)->where("offer_status", ">", 0)->count();
        if ($isOffered) {
            return Redirect::action("Frontend\ShopperController@orderDetail", $order->order_id)->withError(trans("index.vuilonghuyoffercu"));
        }
//        var_dump(Session::get("userFrontend"));die;
        $offer = new Offer();
        $offer->order_id = $order->order_id;
        $offer->traveler_id = Session::get("userFrontend")["account_id"];
        $offer->deliver_date = date("Y-m-d", strtotime($this->request->input("date")));
        $offer->deliver_details = $this->request->input("deliver_details", "");
        $offer->deliver_from = (int)$this->request->input("deliver_from", $order->deliver_from);
        $offer->shipping_fee = (float)$this->request->input("shipping_fee");
        $offer->tax = (float)$this->request->input("tax");
        $offer->others_fee = (float)$this->request->input("other_fee");
        $offer->payment_type = $payment;
        $offer->payment_info_id = $payment_info_id;
        $offer->save();

        try {
            //Create Make Offer Notification
            $data = get_notification($order, $offer, MessageHelper::made_new_offer(), MessageHelper::made_new_offer('en'), 'make_new_offer');
            $notification_id = $this->notification->insert($data);
            $notification = $this->notification->find($notification_id);
            //send mail
            send_mail($notification);

            $notification_inserted = $this->notification->find($notification_id);
            $to_phone = $notification_inserted->to_user->phone_number;


            if ($to_phone) {
//                $to_first_name = $notification_inserted->to_user->first_name;
//                $to_last_name = $notification_inserted->to_user->last_name;

                $message = 'Don hang '.$order->code.' cua ban duoc de nghi mua ho muc tien cong '. $offer->others_fee .'$. Vui long truy cap subsuf.com de hoan tat. Xin cam on!';

                //dd($message);
                MessageHelper::send_sms($to_phone, $message);
            }

        } catch (\Exception $e) {
          //  dd($e->getMessage());
        }

        return Redirect::action("Frontend\ShopperController@orderDetail", $order_id)->withSuccess(trans("index.taoofferthanhcong"));
    }

    function cancelOffer($offer_id)
    {
        $offer = Offer::where("offer_id", $offer_id)->first();
        if (!$offer) {
            return Redirect::action("Frontend\IndexController@error")->withError("Không tìm thấy thông tin offer!");
        }
        if ($offer->traveler_id != Session::get("userFrontend")["account_id"] || $offer->offer_status != 1) {
            return Redirect::action("Frontend\ShopperController@orderDetail", $offer->order_id)->withError(trans("index.bankhongcoquyenhuyoffer"));
        }
        $offer->forceDelete();
        return Redirect::action("Frontend\ShopperController@orderDetail", $offer->order_id)->withSuccess(trans("index.huyyeucaumuahothanhcong"));
    }

    public function finishOrder($offer_id)
    {
        $offer = Offer::where("traveler_id", Session::get("userFrontend")["account_id"])->where("offer_id", $offer_id)->first();
        if (!$offer) {
            abort(404);
        }
        if ($offer->offer_status == 3) {
            return Redirect::action("Frontend\ShopperController@orderDetail", $offer->order_id)->withError("Đã xác nhận chuyển hàng!");
        }
        if ($offer->offer_status != 2) {
            return Redirect::action("Frontend\ShopperController@orderDetail", $offer->order_id)->withError("Offer chưa được xác nhận!");
        }
        $offer->offer_status = 3;
        $offer->received_time = date("Y-m-d H:i:s");
        $offer->save();
        if ($offer->order->order_status == 3) {
            $transaction = Transaction::where("offer_id", $offer->offer_id)->first();
            if ($transaction) {
                $transaction->received_time = date("Y-m-d H:i:s");
                $transaction->transaction_status = 3;
                $transaction->save();
            }
        }
        return Redirect::action("Frontend\ShopperController@orderDetail", $offer->order_id)->withSuccess("Đã xác nhận chuyển hàng!");
    }
}
