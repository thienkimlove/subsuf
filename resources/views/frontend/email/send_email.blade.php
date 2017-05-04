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
                        <strong>{{$notification["from_user"]["first_name"] . " " . $notification["from_user"]["last_name"]}}</strong>
                        {{$notification["content_en"]}}
                        <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
                        ."?notification=" . $notification["notification_id"]}}">
                            {{$notification["order"]["name"]}}
                        </a> at {{date("H:i d-m-Y", strtotime($notification["sent_at"]))}}
                    </p>
                    @if($type == 'cancel_offer')
                        <p>
                            Subsuf will refund your payment to your "Nganluong e-wallet". You will create your e-wallet
                            account by the email and phone number you used to pay for your order at
                            https://www.nganluong.vn (free), you can withdraw your money to bank account from this
                            e-wallet.
                        </p>
                    @endif
                    @if($type == 'accept_offer')
                        <h4>Order detail:</h4>
                        <p> - Item name:
                            <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
                        ."?notification=" . $notification["notification_id"]}}">
                                <b>{{$notification["order"]["name"]}}</b>
                            </a>
                        </p>
                        <p> - Item description:
                            <br>
                            {{$notification["order"]["description"]}}
                        </p>
                        <p> - Website :
                            <a href="{{trim($notification["order"]["link"])}}"
                               target="_blank">{{parse_url(trim($notification["order"]["link"]), PHP_URL_HOST)}}
                            </a>
                        </p>
                        <p>
                            Let's buy it !
                        </p>
                        <p>
                            <strong>Contact to Shopper:</strong>
                            <br>
                            Email: {{$notification["from_user"]["email"]}}
                            <br>
                            Phone number: {{convert_phone_number($notification["from_user"]["phone_number"], 'en')}}
                        </p>
                    @endif
                    <hr>
                    <p>
                        Xin
                        chào, {{$notification["to_user"]["first_name"] . " " . $notification["to_user"]["last_name"]}}
                    </p>
                    <p>
                        <strong>{{$notification["from_user"]["first_name"] . " " . $notification["from_user"]["last_name"]}}</strong>
                        {{$notification["content_vi"]}}
                        <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
                        ."?notification=" . $notification["notification_id"]}}">
                            {{$notification["order"]["name"]}}
                        </a> vào lúc {{date("H:i d-m-Y", strtotime($notification["sent_at"]))}}

                    </p>
                    @if($type == 'cancel_offer')
                        <p>
                            Subsuf sẽ bồi hoàn tiền thanh toán của bạn qua ví Ngân lượng. Bạn sẽ lập 1 tài khoản ví Ngân
                            lượng bằng email và SĐT dùng để thanh toán giao dịch trên Subsuf tại
                            https://www.nganluong.vn (hoàn toàn miễn phí), bạn có thể rút tiền về tài khoản ngân hàng từ
                            đây.
                        </p>
                    @endif
                    @if($type == 'accept_offer')
                        <h4>Thông tin đơn hàng:</h4>
                        <p> - Tên sản phẩm cần mua:
                            <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification["order_id"])
                        ."?notification=" . $notification["notification_id"]}}">
                                <b>{{$notification["order"]["name"]}}</b>
                            </a>
                        </p>
                        <p> - Mô tả:
                            <br>
                            {{$notification["order"]["description"]}}
                        </p>
                        {{--<p> - Giá sản phẩm:--}}
                            {{--<br>--}}
                           {{--<b> ${{number_format($notification["order"]["price"], 2, '.', ',')}} x {{$notification["order"]["quantity"]}}--}}
                            {{--= ${{number_format($notification["order"]["price"]*$notification["order"]["quantity"], 2, '.', ',')}}--}}
                            {{--</b>--}}
                        {{--</p>--}}

                        <p> - Website :
                            <a href="{{trim($notification["order"]["link"])}}"
                               target="_blank">{{parse_url(trim($notification["order"]["link"]), PHP_URL_HOST)}}
                            </a>
                        </p>
                        <p>
                            Bạn đã có thể yên tâm mua hàng rồi!
                        </p>
                        <p>
                            <strong>Liên hệ với người mua hàng:</strong>
                            <br>
                            Email: {{$notification["from_user"]["email"]}}
                            <br>
                            Số điện thoại: {{$notification["from_user"]["phone_number"]}}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>