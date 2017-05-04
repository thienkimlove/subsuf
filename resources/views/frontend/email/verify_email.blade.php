<div class="row">
    <div class="col-md-4">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption text-uppercase">
                    Subsuf.com - Confirm email
                </div>
            </div>

            <div class="portlet-body form">
                <div class="form-body">
                    <p> Hello!, {{$notification["first_name"] . " " . $notification["last_name"]}}</p>
                    <p>
                        You have not confirmed your email yet. Click here to complete your confirmation:

                        <a href="{{URL::action('Frontend\UserController@acceptVerifyEmail',["code"=>$notification["code"]])}}">
                            {{URL::action('Frontend\UserController@acceptVerifyEmail',["code"=>$notification["code"]])}}
                        </a>
                    </p>
                    <p>Thank you for using our service!</p>

                    <hr>

                    <p>Xin chào, {{$notification["first_name"] . " " . $notification["last_name"]}}</p>
                    <p>
                        Bạn chưa xác nhận tài khoản email. vui lòng click vào đường link dưới đây để hoàn tất việc xác
                        nhận
                        <a href="{{URL::action('Frontend\UserController@acceptVerifyEmail',["code"=>$notification["code"]])}}">
                            {{URL::action('Frontend\UserController@acceptVerifyEmail',["code"=>$notification["code"]])}}
                        </a>
                    </p>
                    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
                </div>
            </div>
        </div>
    </div>
</div>