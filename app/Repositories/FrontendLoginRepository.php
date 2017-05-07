<?php
namespace App\Repositories;


use App\Account;
use App\Config;
use App\Coupon;
use App\Helper\EncryptHelper;
use Illuminate\Support\Facades\Session;

class FrontendLoginRepository
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function saveUserSession($account)
    {
        Session::set("userFrontend", $account);
        return true;
    }

    public function getUser($user_id)
    {
        return User::find($user_id);
    }

    public function userShare($code)
    {
        $user = User::where("share_code", $code)->first();
        return $user;
    }

    public function createOrGetUser($data, $type = null)
    {
        if ($type) {
            $account = Account::where('account_type', $type)
                ->where('social_id', $data["social_id"])
                ->first();
        } else {
            $account = Account::where('email', $data["email"])
                ->where('password', EncryptHelper::password($data["password"]))
                ->first();
        }

        if ($account) {
            return $account;
        } else {
            $checkEmail = Account::where('email', '<>', "")
                ->where('email', $data["email"])
                ->first();
            if ($checkEmail) {
                return false;
            }
            $userShare = Session::has("userShare") ? Session::get("userShare")["user_id"] : 0;
            $account = new Account();
            $account->social_id = $data["social_id"];
            $account->account_status = 1;
            $account->account_type = ($type) ? $type : "";
            $account->avatar = $data["avatar"];
            $account->email = ($data["email"]) ? $data["email"] : "";
            $account->password = ($type) ? str_random() : EncryptHelper::password($data["password"]);
            $account->first_name = $data["first_name"];
            $account->last_name = $data["last_name"];
            $account->phone_number = $data["phone_number"];
            $account->share_code = str_slug($data["first_name"] . " " . $data["last_name"], '-') . "-" . str_random(4);
            $account->is_verified = 0;
            $account->from_account_id = $userShare;
            $account->save();
            if ($userShare) {
                $coupon = new Coupon();
                $coupon->coupon_code = $userShare["share_code"];
                $coupon->account_id = $account->account_id;
                $coupon->money = Config::getCouponRegister();
                $coupon->status = 1;
                $coupon->used_at = "";
                $coupon->save();
                Session::forget("userShare");
            }
            return $account;
        }
    }

    public function findWithPayment($account_id)
    {
        return $this->account
            ->with('payment_cards')
            ->with('paypals')
            ->find($account_id);
    }
}