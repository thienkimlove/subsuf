<div class="row">
    <div class="col-md-4">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption text-uppercase">
                    Subsuf.com - Forgot password
                </div>
            </div>

            <div class="portlet-body form">
                <div class="form-body">
                    <p> Hello!, {{$notification["first_name"] . " " . $notification["last_name"]}}</p>
                    <p>
                        You have just requested to reset new password. Click here to change new password:
                        <a href="{{URL::action('Frontend\LoginController@changeNewPassword',["code"=>$notification["code"]])}}">
                            {{URL::action('Frontend\LoginController@changeNewPassword',["code"=>$notification["code"]])}}
                        </a>
                    </p>
                    <p>Thank you for using our service!</p>

                    <hr>

                    <p>Xin chào, {{$notification["first_name"] . " " . $notification["last_name"]}}</p>
                    <p>
                        Bạn vừa yêu cầu reset mật khẩu đăng nhập! Click vào link dưới đây để thay đổi mật khẩu mới:
                        <a href="{{URL::action('Frontend\LoginController@changeNewPassword',["code"=>$notification["code"]])}}">
                            {{URL::action('Frontend\LoginController@changeNewPassword',["code"=>$notification["code"]])}}
                        </a>
                    </p>
                    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
                </div>
            </div>
        </div>
    </div>
</div>