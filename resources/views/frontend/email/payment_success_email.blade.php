<div class="row">
    <div class="col-md-4">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption text-uppercase">
                    Subsuf.com Notification
                </div>
            </div>

            <div class="portlet-body form">
                <div class="form-body">
                    <p>Hi, {{$notification["to_user"]["first_name"] . " " . $notification["to_user"]["last_name"]}}</p>
                    <p>
                        You've paid for order <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
                        ."?notification=" . $notification["notification_id"]}}">
                            {{$notification["order"]["name"]}}
                        </a> at {{date("H:i d-m-Y", strtotime($notification["sent_at"]))}}.

                        <br>
                        <strong>{{$notification["from_user"]["first_name"] . " " . $notification["from_user"]["last_name"]}}</strong>
                        will contact you via email or phone before delivery the items.

                        <br>
                        Thanks for using our service!
                    </p>
                    <hr>
                    <p>
                        Xin
                        chào, {{$notification["to_user"]["first_name"] . " " . $notification["to_user"]["last_name"]}}
                    </p>
                    <p>
                        Bạn đã thanh toán thành công đơn hàng <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
                        ."?notification=" . $notification["notification_id"]}}">
                            {{$notification["order"]["name"]}}
                        </a> vào lúc {{date("H:i d-m-Y", strtotime($notification["sent_at"]))}}.

                        <br>
                        <strong>{{$notification["from_user"]["first_name"] . " " . $notification["from_user"]["last_name"]}}</strong>
                        sẽ liên lạc với bạn qua email hoặc SĐT trước khi giao hàng.

                        <br>
                        Cảm ơn vì đã sử dụng dịch vụ của chúng tôi!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>