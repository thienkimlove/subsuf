<?php

namespace App\Http\Controllers\Frontend;

use App\Account;
use App\AccountRate;
use App\Helper\ImageUpload;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Order;
use App\PaymentCardInfo;
use App\PayPalInfo;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FrontendLoginRepository;
use App\Repositories\ItemRepository;
use App\Repositories\LocationRepository;
use App\Repositories\OrderRepository;
use App\Transaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    private $account;

    public function __construct(Request $request, FrontendLoginRepository $account, ItemRepository $item,
                                CategoryRepository $category, LocationRepository $location, BrandRepository $brand, OrderRepository $order)
    {
        parent::__construct();
        $this->request = $request;
        $this->account = $account;
        $this->category = $category;
        $this->location = $location;
        $this->brand = $brand;
        $this->item = $item;
        $this->order = $order;
        $this->account_id = Session::get("userFrontend")["account_id"];
    }

    public function profile()
    {
        $user = Account::find($this->account_id);
        if (!$user)
            abort(404);
        $response = [
            'title' => trans("index.thongtincanhan"),
            "user" => $user,
            "offerList" => Offer::where("traveler_id", $this->account_id)->orderBy("offer_time", "DESC")->get(),
            "orderList" => Order::where("shopper_id", $this->account_id)->orderBy("request_time", "DESC")->get()
        ];
        return view('frontend.user.profile', $response);
    }

    public function user_payment_info()
    {
        $user = $this->account->findWithPayment($this->account_id);
        if ($user == null) {
            abort(404);
        }
        $response = [
            'title' => trans("index.user_payment_info"),
            "user" => $user,
        ];

        return view('frontend.user.user_payment_info', $response);
    }

    public function inviteFriend()
    {
        $user = $this->account->findWithPayment($this->account_id);
        if ($user == null) {
            abort(404);
        }
        $response = [
            'title' => trans("index.moibanbe"),
            "user" => $user,
        ];
        return view('frontend.user.invite_friend', $response);
    }


    public function add_paypal()
    {
        $response = [
            'title' => trans("index.tkpaypal"),
        ];

        if ($this->request->isMethod('post')) {
            $validator = Validator::make($this->request->all(), [
                'paypal_email' => 'required|confirmed',
                'paypal_email_confirmation' => 'required',
            ], [
                'required' => trans("index.vuilongnhapdayduthongtin"),
                'paypal_email.confirmed' => trans("index.emailnhaplaikhongdung")
            ]);

            if (is_error($validator)) {
                return Redirect::back()->withError($validator->errors()->first());
            }

            if (!is_error($validator)) {
                $paypal = new PayPalInfo();
                $paypal->account_id = $this->account_id;
                $paypal->paypal_email = $this->request->input('paypal_email');
                $paypal->save();
            }

            $user = Account::where("account_id", $this->account_id)->with("payment_cards")->with('paypals')->first();

            if ($user) {
                $this->account->saveUserSession($user);
            }

            return Redirect::back()->withSuccess(trans("index.capnhatthongtinttthanhcong"));
        }

        return view('frontend.user.add_paypal', $response);
    }

    public function delete_paypal($id)
    {
        try {
            PayPalInfo::where('payment_info_id', $id)->where('account_id', $this->account_id)->delete();
            return Redirect::back()->withSuccess(trans("index.capnhatthongtinttthanhcong"));
        } catch (\Exception $e) {
            return Redirect::back();
        }
    }

    public function delete_card($id)
    {
        try {
            PaymentCardInfo::where('payment_info_id', $id)->where('account_id', $this->account_id)->delete();
            return Redirect::back()->withSuccess(trans("index.capnhatthongtinttthanhcong"));
        } catch (\Exception $e) {
            return Redirect::back();
        }
    }

    public function edit_paypal($id)
    {
        $payment = PayPalInfo::where('payment_info_id', $id)->first();
        if ($payment != null) {
            if ($payment->account_id != $this->account_id) {
                return \Redirect::back();
            }

            $response = [
                'title' => trans("index.tkpaypal"),
                'payment' => $payment
            ];

            if ($this->request->isMethod('post')) {
                $validator = Validator::make($this->request->all(), [
                    'paypal_email' => 'required|confirmed',
                    'paypal_email_confirmation' => 'required',
                ], [
                    'required' => trans("index.vuilongnhapdayduthongtin"),
                    'paypal_email.confirmed' => trans("index.emailnhaplaikhongdung")
                ]);

                if (is_error($validator)) {
                    return Redirect::back()->withError($validator->errors()->first());
                }

                if (!is_error($validator)) {
                    $payment->paypal_email = $this->request->input('paypal_email');
                    $payment->save();
                }

                $user = Account::where("account_id", $this->account_id)->with("payment_cards")->with('paypals')->first();

                if ($user) {
                    $this->account->saveUserSession($user);
                }

                return Redirect::back()->withSuccess(trans("index.capnhatthongtinttthanhcong"));
            }

            return view('frontend.user.edit_paypal', $response);
        } else {
            return \Redirect::back();
        }
    }

    public function edit_card($id)
    {
        $payment = PaymentCardInfo::where('payment_info_id', $id)->first();
        if ($payment != null) {
            if ($payment->account_id != $this->account_id) {
                return \Redirect::back();
            }

            $response = [
                'title' => trans("index.taikhoannganhang"),
                'payment' => $payment
            ];

            if ($this->request->isMethod('post')) {
                $validator = Validator::make($this->request->all(), [
                    'account_number' => 'required',
                    'name' => 'required',
//                    'country_of_bank' => 'required',
                    'bank_name' => 'required',
                    'bank_department' => 'required',
//                    'swift_code' => 'required',
                ], [
                    'required' => trans("index.vuilongnhapdayduthongtin"),
                ]);

                if (is_error($validator)) {
                    return Redirect::back()->withError($validator->errors()->first());
                }

                $payment->account_number = trim($this->request->input("account_number"));
                $payment->name = trim($this->request->input("name"));
//                $payment->country_of_bank = $this->request->input("country_of_bank");
                $payment->bank_name = trim($this->request->input("bank_name"));
                $payment->bank_department = trim($this->request->input("bank_department"));
//                $payment->swift_code = $this->request->input("swift_code");
                $payment->save();

                $user = Account::where("account_id", $this->account_id)->with("payment_cards")->with('paypals')->first();

                if ($user) {
                    $this->account->saveUserSession($user);
                }

                return Redirect::back()->withSuccess(trans("index.capnhatthongtinttthanhcong"));
            }

            return view('frontend.user.edit_card', $response);
        } else {
            return \Redirect::back();
        }
    }

    public function add_card()
    {
        $response = [
            'title' => trans("index.taikhoannganhang"),
        ];

        if ($this->request->isMethod('post')) {
            $validator = Validator::make($this->request->all(), [
                'account_number' => 'required',
                'name' => 'required',
//                'country_of_bank' => 'required',
                'bank_name' => 'required',
                'bank_department' => 'required',
//                'swift_code' => 'required',
            ], [
                'required' => trans("index.vuilongnhapdayduthongtin"),
            ]);

            if (is_error($validator)) {
                return Redirect::back()->withError($validator->errors()->first());
            }

            $payment = new PaymentCardInfo();
            $payment->account_id = $this->account_id;
            $payment->account_number = trim($this->request->input("account_number"));
            $payment->name = trim($this->request->input("name"));
//            $payment->country_of_bank = $this->request->input("country_of_bank");
            $payment->bank_name = trim($this->request->input("bank_name"));
            $payment->bank_department = trim($this->request->input("bank_department"));
//            $payment->swift_code = $this->request->input("swift_code");
            $payment->save();

            $user = Account::where("account_id", $this->account_id)->with("payment_cards")->with('paypals')->first();

            if ($user) {
                $this->account->saveUserSession($user);
            }

            return Redirect::back()->withSuccess(trans("index.capnhatthongtinttthanhcong"));
        }

        return view('frontend.user.add_card', $response);
    }

    public function checkVerifyEmail()
    {
        $user = Account::find($this->account_id);
        if ($user->is_verified)
            return [
                "status" => 1,
                "message" => trans("index.daxacnhanemail"),
            ];
        return [
            "status" => 0,
            "message" => trans("index.chuaxacnhanemail"),
        ];
    }

    public function sendVerifyEmail()
    {
        $user = Account::find($this->account_id);
        if (!$user->is_verified) {
            $user->verify_code = str_random(40);
            $user->save();
            $data = [
                "email" => $user->email,
                "code" => $user->verify_code,
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
            ];
            send_mail_verify_email($data);
            return [
                "status" => 1,
                "message" => trans("index.daguiemailden") . " " . $data['email'] . "!",
            ];
        }
        return [
            "status" => 1,
            "message" => trans("index.taikhoancuabandadcxacnhan"),
        ];

    }

    public function acceptVerifyEmail()
    {
        $code = $this->request->input("code");
        if ($code) {
            $user = Account::where("verify_code", $code)->first();
            if (!$user) {
                return Redirect::action("Frontend\IndexController@error")->withError(trans("index.maxacnhankhongdung"));
            }
            $user->is_verified = 1;
            $user->save();
            return Redirect::action("Frontend\IndexController@error")->withSuccess(trans("index.xacnhantkthanhcong"));

        } else {
            return Redirect::action("Frontend\IndexController@error")->withError(trans("index.maxacnhankhongdung"));
        }
    }

    public function updateInfo()
    {
        $validator = Validator::make($this->request->all(), [
            'email' => 'required|email',
            'phone' => 'required',
        ], [
            'required' => trans("index.vuilongnhapdayduthongtin"),
            'email' => trans("index.khongdungdinhdangemail"),

        ]);
        if (is_error($validator)) {
            return Redirect::back()->withError($validator->errors()->first());
        }
        $user = Account::find($this->account_id);
        $user->phone_number = $this->request->input("phone");
        $user->email = $this->request->input("email");
        $user->save();
        Session::set("userFrontend", $user);
        return Redirect::back()->withSuccess(trans("index.capnhatttthanhcong"));
    }

    public function update()
    {
        $validator = Validator::make($this->request->all(), [
            'email' => 'required|email',
            'phone_number' => 'required',
            'name' => 'required',
        ], [
            'required' => trans("index.vuilongnhapdayduthongtin"),
            'email' => trans("index.khongdungdinhdangemail"),

        ]);
        if (is_error($validator)) {
            return Redirect::back()->withError($validator->errors()->first());
        }
        $user = Account::find($this->account_id);
        $user->phone_number = $this->request->input("phone_number");
        $user->first_name = getFirstName($this->request->input("name"));
        $user->last_name = getLastName($this->request->input("name"));

        if ($user->email != $this->request->input("email")) {
            $checkEmail = Account::where("email", $this->request->input("email"))
                ->whereNotIn("account_id", [$this->account_id])
                ->count();
            if ($checkEmail)
                return Redirect::back()->withError(trans("index.emaildatontai"));

            $user->is_verified = 0;
            $user->verify_code = str_random(40);
            $user->email = $this->request->input("email");
            $data = [
                "email" => $user->email,
                "code" => $user->verify_code,
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
            ];
            send_mail_verify_email($data);
            Session::flash("success", trans("index.capnhatttthanhcong_email", ["name" => $user->email]));
        } else {
            Session::flash("success", trans("index.capnhatttthanhcong", ["name" => $user->email]));
        }

        $user->save();

        Session::set("userFrontend", $user);
        return Redirect::back();
    }

    public function paymentInfo()
    {
        $response = [
            'title' => trans("index.capnhatthongtintt"),
        ];
        $location = $this->location->getAll(["type" => 0]);
        $selectLocation[] = "";
        foreach ($location as $item) {
            $selectLocation[$item->location_id] = $item->name;
        }
        $response["location"] = $selectLocation;
        return view('frontend.user.payment', $response);
    }

    public function updatepaymentInfo()
    {
        $validator = Validator::make($this->request->all(), [
            'account_number' => 'required',
            'name' => 'required',
//            'country_of_bank' => 'required',
            'bank_name' => 'required',
            'bank_department' => 'required',
//            'swift_code' => 'required',
        ], [
            'required' => trans("index.vuilongnhapdayduthongtin"),
            'email' => trans("index.khongdungdinhdangemail"),

        ]);

        $validator2 = Validator::make($this->request->all(), [
            'paypal_email' => 'required|confirmed',
            'paypal_email_confirmation' => 'required',
        ], [
            'required' => trans("index.vuilongnhapdayduthongtin"),
            'paypal_email.confirmed' => trans("index.emailnhaplaikhongdung")
        ]);

        if (is_error($validator) && is_error($validator2)) {
            if (is_error($validator)) {
                return Redirect::back()->withError($validator->errors()->first());
            }

            if (is_error($validator2)) {
                return Redirect::back()->withError($validator2->errors()->first());
            }
        }

        if (!is_error($validator)) {
            $payment = new PaymentCardInfo();
            $payment->account_id = $this->account_id;
            $payment->account_number = trim($this->request->input("account_number"));
            $payment->name = trim($this->request->input("name"));
//            $payment->country_of_bank = $this->request->input("country_of_bank");
            $payment->bank_name = trim($this->request->input("bank_name"));
            $payment->bank_department = trim($this->request->input("bank_department"));
//            $payment->swift_code = $this->request->input("swift_code");
            $payment->save();
        }

        if (!is_error($validator2)) {
            $paypal = new PayPalInfo();
            $paypal->account_id = $this->account_id;
            $paypal->paypal_email = $this->request->input('paypal_email');
            $paypal->save();
        }

        $user = Account::where("account_id", $this->account_id)->with("payment_cards")->with('paypals')->first();

        if ($user) {
            $this->account->saveUserSession($user);
        }

        if (Session::has("offer")) {
            return Redirect::to(Session::get("offer")["url_calback"])->withSuccess(trans("index.capnhatthongtinttthanhcong"));
        } else {
            return Redirect::action('Frontend\TravelerController@index')->withSuccess(trans("index.capnhatthongtinttthanhcong"));
        }
    }

    public function userRateDetail($user_id)
    {
        $user = Account::where("account_id", $user_id)->first();
        if (!$user) {
            abort(404);
        }
        $countShopper = $user->rate()->where("type", "shopper")->count();
        $countTraveler = $user->rate()->where("type", "traveler")->count();
        $starShopper = 0;
        $starTraveler = 0;
        if ($countShopper)
            $starShopper = $user->rate()->where("type", "shopper")->sum("star") / $countShopper;
        if ($countTraveler)
            $starTraveler = $user->rate()->where("type", "traveler")->sum("star") / $countTraveler;
        $response = [
            'title' => trans("index.danhgiathanhvien"),
            'user' => $user,
            'starShopper' => $starShopper,
            'starTraveler' => $starTraveler,
        ];
        return view('frontend.user.rate_info', $response);
    }

    public function userRate($transaction_id)
    {
        $transaction = Transaction::find($transaction_id);
        if (!$transaction) {
            abort(404);
        }
        $offer = $transaction->offer;
        $order = $offer->order;
        if ($offer->traveler_id == $this->account_id) {
            $rate = "shopper"; // đánh giá shopper
            $user = $order->account;
        } else if ($order->shopper_id == $this->account_id) {
            $rate = "traveler"; // đánh giá traveler
            $user = $offer->account;

        } else {
            abort(404);
        }
        $response = [
            'title' => trans("index.danhgiathanhvien"),
            'transaction' => $transaction,
            'rate' => $rate,
            'user' => $user,
        ];
        return view('frontend.user.rate', $response);
    }

    public function userRateUpdate($transaction_id)
    {
        $validator = Validator::make($this->request->all(), [
            'star' => 'required|numeric|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withError($validator->errors()->first());
        }
        $transaction = Transaction::find($transaction_id);
        if (!$transaction) {
            abort(404);
        }
        $offer = $transaction->offer;
        $order = $offer->order;
        if ($offer->traveler_id == $this->account_id) {
            $type = "shopper"; // đánh giá shopper
            $user = $order->account;
        } else if ($order->shopper_id == $this->account_id) {
            $type = "traveler"; // đánh giá traveler
            $user = $offer->account;
        } else {
            abort(404);
        }
        $data = [];
        $rate = AccountRate::where("account_id", $user->account_id)
            ->where("transaction_id", $transaction_id)
            ->where("type", $type)->first();
        if (!$rate) {
            $data = [
                "account_id" => $user->account_id,
                "transaction_id" => $transaction_id,
                "type" => $type
            ];
        }
        $data["star"] = $this->request->input("star");
        $data["message"] = $this->request->input("comment");
        $data["time_rate"] = date("Y-m-d H:i:s");
        $data["account_rate"] = $this->account_id;
        if ($rate) {
            AccountRate::where("account_rate_id", $rate->account_rate_id)->update($data);
        } else {
            AccountRate::insert($data);
        }
        return Redirect::action("Frontend\UserController@userRateDetail", $user->account_id)->withSuccess(trans("index.ratesuccess"));

    }

    public function updateImage()
    {
        $validator = Validator::make($this->request->all(), [
            'image' => 'file | image | mimes:gif,jpeg,jpg,png|max:700',
        ], [
                "required" => trans("index.vuilongnhapdayduthongtin"),
                "file" => trans("index.fileuplenkhongphaifileanh"),
                "image" => trans("index.fileuplenkhongphaifileanh"),
                "mimes" => trans("index.fileuplenkhongphaifileanh"),
                "max" => trans("index.kichthuocfilequalon"),
            ]
        );
        if ($validator->fails()) {
            return Redirect::back()->withError($validator->errors()->first());
        }
        $user = Account::find($this->account_id);
        $file = $this->request->file('image');
        $image = ImageUpload::avatar($file, $user->account_id);
        if ($image) {
            $user->avatar = "/" . $image;
            $user->save();
        }
        $this->account->saveUserSession($user);
        return Redirect::back()->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0')->withSuccess(trans("index.capnhatavatarthanhcong"));

    }

    public function offered()
    {
        $user = Account::find($this->account_id);
        if (!$user)
            abort(404);
        $response = [
            'title' => trans("index.thongtincanhan"),
            "user" => $user,
            "offerList" => Offer::where("traveler_id", $this->account_id)->orderBy("offer_time", "DESC")->get(),
            "orderList" => Order::where("shopper_id", $this->account_id)->orderBy("request_time", "DESC")->get()
        ];
        return view('frontend.user.offered', $response);
       // return view('frontend.user.offered', $response);
    }

    public function ordered()
    {
        $user = Account::find($this->account_id);
        if (!$user)
            abort(404);
        $response = [
            'title' => trans("index.thongtincanhan"),
            "user" => $user,
            "offerList" => Offer::where("traveler_id", $this->account_id)->orderBy("offer_time", "DESC")->get(),
            "orderList" => Order::where("shopper_id", $this->account_id)->orderBy("request_time", "DESC")->get()
        ];
        return view('frontend.user.ordered', $response);
    }
}
