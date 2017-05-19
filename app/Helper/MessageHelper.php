<?php

namespace App\Helper;

class MessageHelper
{
    public static function made_new_offer($locale = 'vi')
    {
        if ($locale == 'vi') {
            return "đã tạo một đề nghị mua hộ cho đơn hàng";
        } else {
            return "made a new offer to deliver your order";
        }
    }

    public static function send_sms($to_phone, $message, $locale = 'vi')
    {
        $url = 'http://rest.esms.vn/MainService.svc/json/';
        $fields = array(
            'Phone' => $to_phone,
            'Content' => $message,
            'APIKey' => env('SMS_APIKEY'),
            'SecretKey' => env('SMS_SECRETKEY'),
            'SmsType' => 4,
            'IsUnicode' => 1,
        );

        $fields_string='';

        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_exec($ch);
        curl_close($ch);
    }

    public static function cancel_offer($locale = 'vi')
    {
        if ($locale == 'vi') {
            return "đã hủy đề nghị mua hộ cho đơn hàng";
        } else {
            return "canceled his/her offer to deliver your order";
        }
    }

    public static function was_unable($locale = 'vi')
    {
        if ($locale == 'vi') {
            return "không thể mua hộ đơn hàng";
        } else {
            return "was unable to deliver your order";
        }
    }

    public static function accept_offer($locale = 'vi')
    {
        if ($locale == 'vi') {
            return "đã chấp nhận và thanh toán lời đề nghị mua hộ của bạn cho đơn hàng";
        } else {
            return "has accepted and paid for your offer to delivery order";
        }
    }

    public static function cancel_order($locale = 'vi')
    {
        if ($locale == 'vi') {
            return "đã hủy đơn hàng";
        } else {
            return "canceled his/her order";
        }
    }

    public static function edit_order($locale = 'vi')
    {
        if ($locale == 'vi') {
            return "đã chỉnh sửa đơn hàng";
        } else {
            return "edited his/her order";
        }
    }

    public static function received_order($locale = 'vi')
    {
        if ($locale == 'vi') {
            return "đã nhận được đơn hàng";
        } else {
            return "has received order";
        }
    }

    public static function payment_success($locale = 'vi')
    {
        if ($locale == 'vi') {
            return "{{payment_success}}{{order_name}} đã được thanh toán. {{traveler}} sẽ liên hệ với bạn trước khi giao hàng";
        } else {
            return "{{payment_success}}{{order_name}} successfully paid. {{traveler}} will contact you before delivering the item(s)";
        }
    }

    public static function shopper_received($locale = 'vi')
    {
        if ($locale == 'vi') {
            return "đã nhận được đơn hàng";
        } else {
            return "has received order";
        }
    }
}