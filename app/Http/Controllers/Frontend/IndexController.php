<?php

namespace App\Http\Controllers\Frontend;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Repositories\LocationRepository;
use App\Transaction;
use Carbon\Carbon;
use DB;
use Mail;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    function __construct(Request $request, LocationRepository $location = null)
    {
        parent::__construct();
        $this->request = $request;
        $this->location = $location;
    }

    public function index()
    {

//        var_dump(App::getLocale());die;
        $country = $this->location->getAll();
        $countrySelect = [];
        $proviceSelect = [];
        foreach ($country as $item) {
            if ($item->type == 1)
                $proviceSelect[$item->location_id] = $item->name;
            else
                $countrySelect[$item->location_id] = $item->name;
        }
        $data = [
            "country" => $countrySelect,
            "province" => $proviceSelect,
            "listOrderFinish" => Transaction::where("transaction_status", 3)->limit(6)->orderBy("received_time","DESC")->get()
        ];
        return view('frontend.index', $data);
    }

    public function error()
    {
        return view('frontend.error');
    }

    public function select_language()
    {
//        if (\Cookie::get('selected_language') != null) {
//            return \Redirect::action('Frontend\IndexController@index');
//        }
        if ($this->request->isMethod('post')) {
            $validator = \Validator::make($this->request->all(),
                ['select_language' => 'required'],
                ['required' => trans("index.vuilongnhapdayduthongtin") ]
            );

            if (!$validator->fails()) {
                $selected_language = $this->request->input('select_language', 'vi');
                \Session::set("app_locale", $selected_language);

                return \Response::redirectTo('/')
                    ->withCookie(\Cookie::forever('selected_language', $selected_language));
            }
        }

        $response = [

        ];
        return view('frontend.select_language', $response);
    }

    public function change_language()
    {

        if ($this->request->has('language')) {
            \Session::set("app_locale", trim($this->request->input('language')));
        }

        return \Redirect::action('Frontend\IndexController@index');
    }

    public function promotion_coupon(\Illuminate\Http\Request $request)
    {

        $code = null;
        $responseMsg = null;
        $email = $request->input('email');

        $countHaveCoupon = DB::table('coupon_logs')->where('email', $email)->count();

        if ($countHaveCoupon == 0) {
            DB::beginTransaction();
            $code = 'PROMO-'.substr(uniqid(time()), 0, 8);
            try {

               $couponId = DB::table('coupon')->insertGetId([
                    'coupon_code' => $code,
                    'money' => env('PROMOTION_COUPON_AMOUNT'),
                    'status' => 1,
                    'used_at' => ''
                ]);

                DB::table('coupon_logs')->insert([
                    'email' => $email,
                    'coupon_id' => $couponId,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ]);

                DB::commit();
                $responseMsg = trans('index.chucmungnhanduoccopon'). ' '.$code;

                Mail::send('frontend.email.promotion_coupon',
                    ['code' => $code],
                    function ($message) use($email) {
                        $message->to($email);
                        $message->subject("Subsuf.com Notifications");
                    });

            } catch (\Exception $e) {
                DB::rollback();
                $responseMsg = trans('index.loikhitaocode');
            }

        }  else {
            $responseMsg = trans('index.dacomacode');
        }
        return response()->json(['msg' => $responseMsg]);

    }
}
