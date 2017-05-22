<?php

namespace App\Http\Controllers\Frontend;

use App;
use App\Account;
use App\ForgotPassword;
use App\Helper\EncryptHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\FrontendLoginRepository;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Socialite;

class LoginController extends Controller
{
    use App\Traits\CaptchaTrait;

    public function __construct(Request $request, FrontendLoginRepository $account)
    {
        parent::__construct();
        $this->request = $request;
        $this->account = $account;
    }

    public function login()
    {
        if (Session::has("userFrontend"))
            return Redirect::action("Frontend\IndexController@index");
       // return view('frontend.user.login', []);
        return view('v2.user.login', []);
    }

    public function doLogin()
    {

        $validator = Validator::make($this->request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'required' => trans("index.vuilongnhapdayduthongtin"),
        ]);
        if (is_error($validator)) {
            return_error($validator, $response);
        }
        $user = Account::where("email", $this->request->input("email"))->with("payment_cards")->with('paypals')
            ->where("password", EncryptHelper::password($this->request->input("password")))->first();

        if ($user) {
            $this->account->saveUserSession($user);
            if (Session::has("url_callback")) {
                $url = Session::get("url_callback");
                Session::forget("url_callback");
                return Redirect::to($url)->withSuccess(trans("index.dangnhapthanhcong"));
            }
            return Redirect::action("Frontend\IndexController@index")->withSuccess(trans("index.dangnhapthanhcong"));
        }
        return Redirect::action("Frontend\LoginController@login")->withError(trans("index.taikhoandangnhapkhongdung"));

    }

    public function register()
    {
        if ($this->request->has("sharecode")) {
            $userShare = $this->account->userShare($this->request->get("sharecode"));
            if ($userShare) Session::set("userShare", $userShare);
        }
        if (Session::has("userFrontend"))
            return Redirect::action("Frontend\IndexController@index");

       // return view('frontend.user.register');
        return view('v2.user.register');
    }

    public function doRegister()
    {
        $params = $this->request->all();
//        $params['captcha'] = $this->captchaCheck();

        $validator = Validator::make($params, [
            'email' => 'required|email',
            'password' => 'required|min:6',
//            'g-recaptcha-response' => 'required',
            'captcha' => 'required|captcha',
        ], [
            'required' => trans("index.vuilongnhapdayduthongtin"),
            'email' => trans("index.khongdungdinhdangemail"),
            'password.min' => trans("index.matkhauphaichua6kytu"),
//            'g-recaptcha-response.required' => 'Yêu cầu nhập Captcha',
//            'captcha.min' => 'Sai Captcha. Vui lòng thử lại'
            'captcha.required' => trans('index.captcha_required'),
            'captcha.captcha' => trans('index.captcha_failed'),
        ]);

        if ($validator->fails()) {
            return Redirect::action('Frontend\LoginController@register')->withError($validator->errors()->first());
        }
//        if($this->request->input("password")!=$this->request->input("repassword")){
//            return Redirect::back()->withError("Sai mật khẩu nhập lại");
//        }

        $name = explode("@", $this->request->input("email"));
        $account = [
            'social_id' => 0,
            'avatar' => "/upload/front-account/default-avatar.jpg",
            'email' => $this->request->input("email"),
            'password' => $this->request->input("password"),
//            'first_name' => getFirstName($name[0]),
            'first_name' => "",
//            'last_name' => getLastName($name[0]),
            'last_name' => $name[0],
            'phone_number' => "",
            'share_code' => "",
            'is_verified' => 0,
            'from_account_id' => null,
        ];
        $user = $this->account->createOrGetUser($account, null);
        if (!$user) {
            return Redirect::action("Frontend\LoginController@login")->withError(trans("index.emailnaydadcdangky"));
        }
        $this->account->saveUserSession($user);
        if (Session::has("url_callback")) {
            $url = Session::get("url_callback");
            Session::forget("url_callback");
            return Redirect::to($url)->withSuccess("Đăng nhập thành công!");
        }
        return Redirect::action("Frontend\IndexController@index")->withSuccess(trans("index.dangnhapthanhcong"));
    }

    public function login_facebook()
    {
        $fb = App::make('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');
        $login_link = $fb->getLoginUrl();

        return \Redirect::to($login_link);
    }

    public function login_facebook_callback()
    {
        $fb = App::make('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');

        // Obtain an access token.
        try {
            $token = $fb->getAccessTokenFromRedirect();

            // Access token will be null if the user denied the request
            // or if someone just hit this URL outside of the OAuth flow.
            if (!$token) {
                // Get the redirect helper
                $helper = $fb->getRedirectLoginHelper();

                return \Redirect::action('Frontend\LoginController@login');
            }

            if (!$token->isLongLived()) {
                // OAuth 2.0 client handler
                $oauth_client = $fb->getOAuth2Client();

                // Extend the access token.
                try {
                    $token = $oauth_client->getLongLivedAccessToken($token);
                } catch (FacebookSDKException $e) {
//                    dd($e->getMessage());
                }
            }

            $fb->setDefaultAccessToken($token);

            // Get basic info on the user from Facebook.
            try {
                $response = $fb->get('/me?fields=id,first_name,last_name,name,email,picture.width(250).height(250)');

                // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
                $facebook_user = $response->getGraphUser();

                $account = [
                    'social_id' => $facebook_user->getId(),
                    'avatar' => $facebook_user->getPicture()->getUrl(),
                    'email' => $facebook_user->getEmail(),
                    'password' => "",
                    'first_name' => $facebook_user->getFirstName(),
                    'last_name' => $facebook_user->getLastName(),
                    'phone_number' => "",
                    'share_code' => "",
                    'is_verified' => 0,
                    'from_account_id' => null,
                ];

                $user = $this->account->createOrGetUser($account, "facebook");
                if (!$user) {
                    return Redirect::action("Frontend\LoginController@login")->withError(trans("index.emailnaydadcdangky"));
                }
                $this->account->saveUserSession($user);
                if (Session::has("url_callback")) {
                    $url = Session::get("url_callback");
                    Session::forget("url_callback");
                    return Redirect::to($url)->withSuccess(trans("index.dangnhapthanhcong"));
                }
                return Redirect::action("Frontend\ShopperController@index")->withSuccess(trans("index.dangnhapthanhcong"));
            } catch (FacebookSDKException $e) {
                return \Redirect::action('Frontend\LoginController@login');
            } catch (\Exception $e) {
                $token = $fb->getDefaultAccessToken();
                $fb->delete("/" . $facebook_user->getId() . "/permissions?access_token=" . $token);
                $fb->setDefaultAccessToken("");
                return \Redirect::action('Frontend\LoginController@login')->withError(trans("index.khongthedangnhapfacebook"));
            }
        } catch (FacebookSDKException $e) {
            return \Redirect::action('Frontend\LoginController@login')->withError(trans("index.khongthedangnhapfacebook"));
        }
    }

    public function facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
//        try {
        $facebookUser = Socialite::driver('facebook')->user();
//            copy($account->avatar, "/upload/front-account/server/$facebookUser->id.jpg");
        $account = [
            'social_id' => $facebookUser->id,
            'avatar' => $facebookUser->avatar,
            'email' => $facebookUser->email,
            'password' => "",
            'first_name' => getFirstName($facebookUser->name),
            'last_name' => getLastName($facebookUser->name),
            'phone_number' => "",
            'share_code' => "",
            'is_verified' => 0,
            'from_account_id' => null,
        ];
        $user = $this->account->createOrGetUser($account, "facebook");
        if (!$user) {
            return Redirect::action("Frontend\LoginController@login")->withError(trans("index.emailnaydadcdangky"));
        }
        $this->account->saveUserSession($user);
        if (Session::has("url_callback")) {
            $url = Session::get("url_callback");
            Session::forget("url_callback");
            return Redirect::to($url)->withSuccess(trans("index.dangnhapthanhcong"));
        }
        return Redirect::action("Frontend\ShopperController@index")->withSuccess(trans("index.dangnhapthanhcong"));
//        } catch (\Exception $e) {
//            echo "Access denied!";
//        }
    }

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
//        var_dump($googleUser);
//        die;
        $account = [
            'social_id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            'email' => $googleUser->email,
            'password' => "",
            'first_name' => $googleUser->user["name"]["familyName"],
            'last_name' => $googleUser->user["name"]["givenName"],
            'phone_number' => "",
            'share_code' => "",
            'is_verified' => 0,
            'from_account_id' => null,
        ];
        $user = $this->account->createOrGetUser($account, "google");
        if (!$user) {
            return Redirect::action("Frontend\LoginController@login")->withError(trans("index.emailnaydadcdangky"));
        }
        $this->account->saveUserSession($user);
        if (Session::has("url_callback")) {
            $url = Session::get("url_callback");
            Session::forget("url_callback");
            return Redirect::to($url)->withSuccess(trans("index.dangnhapthanhcong"));
        }
        return Redirect::action("Frontend\IndexController@index")->withSuccess(trans("index.dangnhapthanhcong"));
//        try {
//            die;
//        } catch (\Exception $e) {
//            echo "Access denied!";
//        }
    }

    public function forgotPassword()
    {
        if (Session::has("userFrontend"))
            return Redirect::action("Frontend\IndexController@index");
        return view('frontend.user.forgot_password', []);
    }

    public function sendEmailForgotPassword()
    {
        if (Session::has("userFrontend"))
            return Redirect::action("Frontend\IndexController@index");
        $validator = Validator::make($this->request->all(),
            [
                "email" => "required|email",
            ],
            [
                'required' => trans("index.vuilongnhapdayduthongtin"),
                'email' => trans("index.khongdungdinhdangemail"),
            ]
        );
        if ($validator->fails()) {
            return Redirect::back()->withError($validator->errors()->first());
        }
        $user = Account::where("email", $this->request->input("email"))->first();
        if (!$user) {
            return Redirect::back()->withError(trans("index.taikhoankhongtontai"));
        }
        $code = str_random(45);
        $check = ForgotPassword::where("code", $code)->count();
        while ($check) {
            $code = str_random(45);
            $check = ForgotPassword::where("code", $code)->count();
        }
        $check2 = ForgotPassword::find($user->account_id);
        if ($check2)
            ForgotPassword::where("account_id", $user->account_id)->update([
                "code" => $code
            ]);
        else
            ForgotPassword::insert([
                "account_id" => $user->account_id,
                "code" => $code
            ]);


        $data = [
            "email" => $user->email,
            "code" => $code,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
        ];
        send_mail_forgot_password($data);
        return Redirect::back()->withSuccess(trans("index.daguiemailtaomatkhaumoi"));

    }

    public function changeNewPassword()
    {
        $validator = Validator::make($this->request->all(),
            [
                "code" => "required",
            ]
        );
        if ($validator->fails()) {
            return Redirect::action("Frontend\IndexController@error")->withError(trans("index.yeucaudahethan"));
        }
        $code = $this->request->input("code");
        $user = ForgotPassword::where("code", $code)->first();
        if (!$user) {
            return Redirect::action("Frontend\IndexController@error")->withError(trans("index.yeucaudahethan"));
        }

        $data = [
            "code" => $code,
//            "user" => $user
        ];
        return view('frontend.user.change_new_password', $data);

    }

    public function doChangeNewPassword()
    {
        $validator = Validator::make($this->request->all(),
            [
                "code" => "required",
                'password' => 'required|min:6',
                'repassword' => 'required|min:6',
            ],
            [
                'required' => trans("index.vuilongnhapdayduthongtin"),
                'password.min' => trans("index.matkhauphaichua6kytu"),
            ]
        );
        if ($validator->fails()) {
            return Redirect::back()->withError($validator->errors()->first());
        }
        if ($this->request->input("password") != $this->request->input("repassword")) {
            return Redirect::back()->withError(trans("index.matkhaunhaplaikhongdung"));

        }
        $code = $this->request->input("code");
        $check = ForgotPassword::where("code", $code)->first();
        if (!$check) {
            return Redirect::action("Frontend\IndexController@error")->withError(trans("index.yeucaudahethan"));
        }
        $user = Account::find($check->account_id);
        if (!$user) {
            return Redirect::action("Frontend\IndexController@error")->withError(trans("index.yeucaudahethan"));
        }

        $user->password = EncryptHelper::password($this->request->input("password"));
        $user->save();
        $check->delete();
        return Redirect::action("Frontend\LoginController@login")->withSuccess(trans("index.doimatkhauthanhcong"));

    }

    public function logout()
    {
        Session::forget("userFrontend");

        return Redirect::back();
    }
}
