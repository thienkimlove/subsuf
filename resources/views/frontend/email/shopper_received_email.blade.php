Hi, {{$notification["to_user"]["first_name"] . " " . $notification["to_user"]["last_name"]}} <br>

<strong>{{$notification["from_user"]["first_name"] . " " . $notification["from_user"]["last_name"]}}</strong>
has received order <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
                        ."?notification=" . $notification["notification_id"]}}">
    {{$notification["order"]["name"]}}
</a> at {{date("H:i d-m-Y", strtotime($notification["sent_at"]))}}.

We will release your payment to your signed account in 3-5 working days.

Please comment or rate
for {{$notification["from_user"]["first_name"] . " " . $notification["from_user"]["last_name"]}} at <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
                        ."?notification=" . $notification["notification_id"]}}">here</a>,
so that others can view.
Thanks again for using our service!

<hr>

Xin chào, {{$notification["to_user"]["first_name"] . " " . $notification["to_user"]["last_name"]}} <br>

<strong>{{$notification["from_user"]["first_name"] . " " . $notification["from_user"]["last_name"]}}</strong>
đã nhận được đơn hàng <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
    ."?notification=" . $notification["notification_id"]}}">
    {{$notification["order"]["name"]}}
</a> vào lúc {{date("H:i d-m-Y", strtotime($notification["sent_at"]))}}.

Bạn sẽ nhận được tiền thanh toán qua tài khoản đã đăng ký từ 3-5 ngày làm việc.

Bạn hãy vào <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
                        ."?notification=" . $notification["notification_id"]}}">đây</a> đánh giá
cho {{$notification["from_user"]["first_name"] . " " . $notification["from_user"]["last_name"]}}
để những Traveler khác có thể tham khảo nhé.

Cảm ơn một lần nữa vì đã sử dụng dịch vụ của chúng tôi!