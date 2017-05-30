<?php
function getDomain($url)
{
    if (filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === FALSE) {
        return false;
    }
    /*** get the url parts ***/
    $parts = parse_url($url);
    /*** return the host domain ***/
    return $parts['scheme'] . '://' . $parts['host'];
}

function get_currency_text($currency=Null)
{
    if(!empty($currency))
    {
        if($currency == 'usd')
        {
            return '$';
        } else if ($currency == 'vnd')
        {
            return 'VNĐ';
        }
    }

    return '$';
}

function get_service_percent($total = 0)
{
    if ($total < 250) {
        $fee = 0.07;
    } else {
        $fee = 0.05;
    }
    return $fee;
}

function category_website()
{
    return 1;
}

function category_item()
{
    return 2;
}

function get_featured()
{
    return 1;
}

function get_policy()
{
    return 1;
}

function get_term()
{
    return 2;
}

function get_about()
{
    return 3;
}

function buy_where()
{
    return 1;
}

function where_buy()
{
    return 2;
}

function famous_brand()
{
    return 3;
}

function get_nation()
{
    return 0;
}

function get_city()
{
    return 1;
}

function get_limit()
{
    return 30;
}

function get_avatar()
{
    if (Session::has('admin')) {
        $admin = Session::get('admin');
        if ($admin->avatar != '') {
            return $admin->avatar;
        }

        return '/assets/pages/media/profile/default_user.jpg';
    }

    return '/assets/pages/media/profile/default_user.jpg';
}

function message_internal_error()
{
    return 'Hệ thống xảy ra sự cố. Vui lòng thử lại.';
}

function message_not_found()
{
    return 'Không tìm thấy bản ghi';
}

function message_update()
{
    return 'Cập nhật bản ghi thành công';
}

function message_delete()
{
    return 'Xóa bản ghi thành công';
}

function message_insert()
{
    return 'Thêm bản ghi thành công';
}

function get_admin_session()
{
    if (Session::has('admin')) {
        return Session::get('admin');
    }

    return null;
}

function get_admin_avatar_folder()
{
    return 'upload/admin/account-admin/';
}

function get_front_account_folder()
{
    return 'upload/front-account/';
}

function get_website_image_folder()
{
    return 'upload/admin/website/';
}

function get_location_image_folder()
{
    return 'upload/admin/location/';
}

function get_category_image_folder()
{
    return 'upload/admin/category/';
}

function get_item_image_folder()
{
    return 'upload/admin/item/';
}

function get_brand_image_folder()
{
    return 'upload/admin/brand/';
}

function get_order_image_folder()
{
    return 'upload/order/images/';
}

function get_blog_image_folder()
{
    return 'upload/blog/';
}
function get_deal_image_folder()
{
    return 'upload/deal/';
}

function get_image_name($image_path)
{
    $last_position = strrpos($image_path, '/');
    return substr($image_path, $last_position + 1);
}

function store_image($request, $image_path, $name = 'image')
{
    $path_info = pathinfo($request->file($name)->getClientOriginalName());
    $file_name = $path_info['filename'] . '_' . date('ymdHis') . '.' . $path_info['extension'];

    $avatar_img = Image::make($request->file($name));
    $avatar_img->save($image_path . $file_name);

    return '/' . $image_path . $file_name;
}

function hide_long_text($text)
{
    if (strlen($text) > 50) {
        $text = substr($text, 0, 50) . ' ...';
    }

    return $text;
}

function get_first_day_of_this_month()
{
    return date("Y-m-01");
}

function get_last_day_of_this_month()
{
    return date("Y-m-t");
}

function humanTiming($time, $language = 'en')
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => (($language == 'vi') ? 'năm' : 'year'),
        2592000 => (($language == 'vi') ? 'tháng' : 'month'),
        604800 => (($language == 'vi') ? 'tuần' : 'week'),
        86400 => (($language == 'vi') ? 'ngày' : 'day'),
        3600 => (($language == 'vi') ? 'giờ' : 'hour'),
        60 => (($language == 'vi') ? 'phút' : 'minute'),
        1 => (($language == 'vi') ? 'giây' : 'second')
    );

    $s = '';
    if ($language != 'vi') {
        $s = 's';
    }

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? $s : '') . ($language == 'vi' ? ' trước' : ' ago');
    }

}

function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false)
{
    $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
    $str_end = "";
    if ($lower_str_end) {
        $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
    } else {
        $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
    }
    $str = $first_letter . $str_end;
    return $str;
}

function getFirstName($name)
{
//    $parts = explode(" ", $name);
//    return array_shift($parts);
    $name = trim($name);
    if (str_word_count($name) == 1) {
        return $name;
    }
    return trim(substr($name, 0, strpos($name, " ")));
}

function getLastName($name)
{
//    $parts = explode(" ", $name);
//    $lastname = array_pop($parts);
//    return implode(" ", $parts);
    $name = trim($name);
    if (str_word_count(trim($name)) == 1) {
        return "";
    }
    return trim(substr($name, strpos($name, " "), strlen($name)));
}

function phone_format($phone)
{
    return substr($phone, 0, 3) . ' ' .
    substr($phone, 3, 3) . ' ' .
    substr($phone, 6);
}

function get_day($from, $to)
{
    $diff = date_diff(date_create($from), date_create($to));
    $day_diff = $diff->days;
    $days = [];

    for ($i = 0; $i <= $day_diff; $i++) {
        if (!in_array($from, $days)) {
            $days[] = $from;
        }

        $from = date('Y-m-d', strtotime("+1 days", strtotime($from)));
    }

    return $days;
}

function havePermission($module, $function)
{
    if (!Session::has("authorities")) return false;
    $authorities = Session::get("authorities");

    if (!isset($authorities)) return false;
    foreach ($authorities as $item) {
        if ($item->module_slug == $module) {
            if ($function == "") return true;
            if ($item->function_slug == $function) return true;
        }
    }

    return false;
}

function get_host($link)
{
    return parse_url($link)['host'];
}

function send_mail($notification, $type = "", $param = null)
{
    try {
        if ($notification->to_user->email != "") {
            // thanh toán thành công
            if ($type == 'payment_success') {
                Mail::send('frontend.email.payment_success_email',
                    ['notification' => $notification, 'type' => $type],
                    function ($message) use ($notification, $type) {
                        $message->to($notification->to_user->email);
                        $message->subject("Subsuf.com Notifications");
                    });
            } elseif ($type == 'shopper_received') {
                Mail::send('frontend.email.shopper_received_email',
                    ['notification' => $notification, 'type' => $type],
                    function ($message) use ($notification, $type) {
                        $message->to($notification->to_user->email);
                        $message->subject("Subsuf.com Notifications");
                    });
            } else {
                Mail::send('frontend.email.send_email',
                    ['notification' => $notification, 'type' => $type],
                    function ($message) use ($notification, $type) {
                        $message->to($notification->to_user->email);
                        $message->subject("Subsuf.com Notifications");
                    });
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function send_mail_verify_email($data)
{
    try {
        if ($data["email"] != "") {
            Mail::send('frontend.email.verify_email',
                ['notification' => $data],
                function ($message) use ($data) {
                    $message->to($data["email"]);
                    $message->subject("Subsuf.com Confirm email");
                });
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}

function send_mail_forgot_password($data)
{
    try {
        if ($data["email"] != "") {
            Mail::send('frontend.email.forgot_password',
                ['notification' => $data],
                function ($message) use ($data) {
                    $message->to($data["email"]);
                    $message->subject("Subsuf.com Forgot password");
                });
            return true;
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function reltativeDate($date)
{
//    $date = date("Y-m-d H:i:s",strtotime($date_str));
//    $string =  HumanRelativeDate::getInstance()->getTextForSQLDate($date);
    $event_timestamp = strtotime($date);
    $current_timestamp = time();
    $diff = $event_timestamp - $current_timestamp;
    $diff = abs($diff);
    if ($diff > 0 && $diff < 3600) {
        $string = floor($diff / 60) . ' ' . trans('index.phuttruoc');
    } else if ($diff < (3600 * 2)) {
        $string = '1 ' . trans('index.giotruoc');
    } else if ($diff < 86400) {
        $string = floor($diff / 3600) . ' ' . trans('index.giotruoc');
    } else {
        $string = date("d-m-Y", strtotime($date));
    }
    return $string;
}

function faq_shopper()
{
    return 1;
}

function faq_traveler()
{
    return 2;
}

function faq_others()
{
    return 3;
}

function get_payment_success_message($notification, $locale = "vi")
{
    $message = '';
    if ($notification) {
            $message = str_replace("{{payment_success}}", "", $notification["content_" . $locale]);
            if($notification->order) {
                $message = str_replace("{{order_name}}", $notification->order->name, $message);
            }
            $message = str_replace("{{traveler}}", trim($notification->from_user->first_name . " " . $notification->from_user->last_name), $message);

    }

    return $message;
}

function convert_phone_number($phone_number, $locale = "vi")
{
    if (strlen($phone_number) < 0) {
        return "";
    }

    $convert_phone = $phone_number;

    if ($locale == 'en') {
        $zero_number = (int)substr($convert_phone, 0, 1);
        if ($zero_number == 0) {
            $convert_phone = "(+84) " . substr($convert_phone, 1);
        }
    }

    return $convert_phone;
}