<?php

namespace App\Helper;

use Monolog\Logger;

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

    public static function send_sms_vt($to_phone, $message, $locale = 'vi')
    {
        $client = new \SoapClient('http://203.190.170.41:8998/wscpmt?wsdl');
        $response = $client->__soapCall('wsCpMt', []);

        dd($response);



    }

    public static function send_sms($to_phone, $message, $locale = 'vi')
    {
        $url = 'http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get';
        $fields = array(
            'Phone' => $to_phone,
            'Content' => urlencode($message),
            'APIKey' => env('SMS_APIKEY'),
            'SecretKey' => env('SMS_SECRETKEY'),
            'SmsType' => 4,
            'IsUnicode' => 1,
        );

        $fields_string = '';

        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }

        $result_json = file_get_contents($url . '?' . $fields_string);

        $result = json_decode($result_json, true);

        $code_result = '';

        $error_message = '';

        if (isset($result['CodeResult'])) {
            $code_result = $result['CodeResult'];
        }

        if (isset($result['ErrorMessage'])) {
            $error_message = $result['ErrorMessage'];
        }

        \Log::info('Send message to ' . $to_phone . ', code: ' . $code_result . 'error: ' . $error_message);
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
            return "{{payment_success}}{{order_name}}, mã đơn: {{code}} đã được thanh toán. {{traveler}} sẽ liên hệ với bạn trước khi giao hàng";
        } else {
            return "{{payment_success}}{{order_name}}, order code: {{code}} successfully paid. {{traveler}} will contact you before delivering the item(s)";
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