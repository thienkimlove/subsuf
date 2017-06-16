<?php

namespace App\Http\Controllers\Frontend;

use App\Coupon;
use App\Helper\CouponHelper;
use App\Helper\NL_Checkout;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Repositories\ExchangeRepository;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    public function __construct(Request $request, ExchangeRepository $exchangeRepository)
    {
        parent::__construct();
        $this->request = $request;
        $this->exchange = $exchangeRepository;
    }

    public function payment_order($offer_id)
    {
        if ($this->request->isMethod('post')) {
            $account_id = \Session::get("userFrontend")["account_id"];
            $offer = Offer::find($offer_id);
            if (!$offer) {
                return \Redirect::action("Frontend\IndexController@error")->withError(trans("index.khongtimthaythongtinoffer"));
            }
            if ($offer->offer_status != 1) {
                return \Redirect::action("Frontend\IndexController@error")->withError(trans("index.offerdahethan"));
            }
            $order = $offer->order;
            if ($order->shopper_id != $account_id) {
                return \Redirect::action("Frontend\IndexController@error")->withError(trans("index.bankhongphaichumonhang"));
            }
            $exchange = $this->exchange->change("USD", "VND");

            if ($exchange == 0) {
                return \Redirect::back()->withError(trans("index.khongquydoiduoctigia"));
            }


            $coupon_id = 0;
            if ($this->request->has("coupon")) {
                $coupon_id = $this->request->input("coupon");
            }

            $coupon = Coupon::whereIn("account_id", [$account_id, 0])
                ->where("amount", ">", 0)
                ->where("coupon_id", $coupon_id)->where("status", 1)->get();

            if ($coupon->count() > 0) {
                $coupon = $coupon->first();
            } else {
                $coupon = null;
            }


            $total_order = (float)$order->price * $order->quantity +
                $offer->shipping_fee + $offer->tax + $offer->others_fee;

            $absoluteTotal = $total_order * (1 + get_service_percent());

            $discount = ($coupon) ?  CouponHelper::getRealCouponAmountByTotal($absoluteTotal, $coupon->money, $coupon->type, $coupon->primary_percent, $coupon->secondary_percent) : 0;

            $total = round($total_order * (1 + get_service_percent()) - $discount, 2);

            // Lấy các tham số để chuyển sang Ngânlượng thanh toán:
            $receiver = config('app.RECEIVER');
            $currency = config('app.CURRENCY');
            //Mã đơn hàng 
            $order_code = 'SUBSUF_' . time();

            //Khai báo url trả về
            $return_url = \URL::action('Frontend\ShopperController@saveAcceptOffer', [$account_id, $offer_id, $coupon_id]);
            //Link nút hủy đơn hàng
            $cancel_url = \URL::action('Frontend\ShopperController@acceptOffer', $offer_id);
            //Giá của cả giỏ hàng
            $txt_name = $order->account->first_name . " " . $order->account->last_name;
            $txt_email = $order->account->email;
            $txt_phone = $order->account->phone_number;
            if ($currency == 'usd') {
                $price = $total;
            } else {
                $price = (int)$exchange * $total;
            }
            //Thông tin giao dịch
            $transaction_info = "Thong tin giao dich";
            $quantity = 1;
            $tax = 0;
            $discount = 0;
            $fee_cal = 0;
            $fee_shipping = 0;
            $order_description = "Thong tin don hang: " . $order_code;
            $buyer_info = $txt_name . "*|*" . $txt_email . "*|*" . $txt_phone;
            $affiliate_code = "";

            //Khai báo đối tượng của lớp NL_Checkout
            $nl = new NL_Checkout();
            $nl->nganluong_url = config('app.NGANLUONG_URL');
            $nl->merchant_site_code = config('app.MERCHANT_ID');
            $nl->secure_pass = config('app.MERCHANT_PASS');


            //Tạo link thanh toán đến nganluong.vn
            $url = $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount, $fee_cal, $fee_shipping, $order_description, $buyer_info, $affiliate_code);
            //$url= $nl->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price);

//            echo $url;
//            die;

            if ($order_code != "") {
                //một số tham số lưu ý
                //&cancel_url=http://yourdomain.com --> Link bấm nút hủy giao dịch
                //&option_payment=bank_online --> Mặc định forcus vào phương thức Ngân Hàng
                $url .= '&cancel_url=' . $cancel_url;
//                $url .= '&option_payment=bank_online';

                return \Redirect::to($url);

             //   return \Redirect::action('Frontend\ShopperController@saveAcceptOffer', [$account_id, $offer_id, $coupon_id]);

                //&lang=en --> Ngôn ngữ hiển thị google translate
            }
        }
    }

    public function payment()
    {
        if ($this->request->isMethod('post')) {
            // Lấy các tham số để chuyển sang Ngânlượng thanh toán:
            $receiver = config('app.RECEIVER');
            $currency = "vnd";
            //Mã đơn hàng 
            $order_code = 'SUBSUF_' . time();
            //Khai báo url trả về
            $return_url = \URL::action('Frontend\PaymentController@success');
            //Link nút hủy đơn hàng
            $cancel_url = \URL::current();
            //Giá của cả giỏ hàng
            $txt_name = $this->request->input('txt_name');
            $txt_email = $this->request->input('txt_email');
            $txt_phone = $this->request->input('txt_phone');
            if ($currency == "usd") {
                $price = round($this->request->input('txt_gia'), 2);
            } else {
                $price = (int)($this->request->input('txt_gia'));
            }


            //Thông tin giao dịch
            $transaction_info = "Thong tin giao dich";
            $quantity = 1;
            $tax = 0;
            $discount = 0;
            $fee_cal = 0;
            $fee_shipping = 0;
            $order_description = "Thong tin don hang: " . $order_code;
            $buyer_info = $txt_name . "*|*" . $txt_email . "*|*" . $txt_phone;
            $affiliate_code = "";

            //Khai báo đối tượng của lớp NL_Checkout
            $nl = new NL_Checkout();
            $nl->nganluong_url = config('app.NGANLUONG_URL');
            $nl->merchant_site_code = config('app.MERCHANT_ID');
            $nl->secure_pass = config('app.MERCHANT_PASS');

            //Tạo link thanh toán đến nganluong.vn
            $url = $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount, $fee_cal, $fee_shipping, $order_description, $buyer_info, $affiliate_code);
            //$url= $nl->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price);

//            echo $url;
//            die;

            return \Redirect::to($url);
            if ($order_code != "") {
                //một số tham số lưu ý
                //&cancel_url=http://yourdomain.com --> Link bấm nút hủy giao dịch
                //&option_payment=bank_online --> Mặc định forcus vào phương thức Ngân Hàng
                $url .= '&cancel_url=' . $cancel_url;
//                $url .= '&option_payment=bank_online';

                return \Redirect::to($url);
                //&lang=en --> Ngôn ngữ hiển thị google translate
            }
        }

        return view('frontend.payment.payment');
    }

    public function success()
    {
        if (isset($_GET['payment_id'])) {
            // Lấy các tham số để chuyển sang Ngânlượng thanh toán:
            $transaction_info = $_GET['transaction_info'];
            $order_code = $_GET['order_code'];
            $price = $_GET['price'];
            $payment_id = $_GET['payment_id'];
            $payment_type = $_GET['payment_type'];
            $error_text = $_GET['error_text'];
            $secure_code = $_GET['secure_code'];

            //Khai báo đối tượng của lớp NL_Checkout
            $nl = new NL_Checkout();
            $nl->merchant_site_code = config('app.MERCHANT_ID');
            $nl->secure_pass = config('app.MERCHANT_PASS');
            //Tạo link thanh toán đến nganluong.vn
            $checkpay = $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);

            if ($checkpay) {
                echo 'Payment success: <pre>';
                // bạn viết code vào đây để cung cấp sản phẩm cho người mua
                print_r($_GET);
            } else {
                echo trans("index.thanhtoanthatbai");
            }
        } else {
            echo trans("index.khongcothongtinthanhtoan");
        }
    }
}
