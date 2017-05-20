
@extends('v2.template')

@section('content')
<div class="wrap_container">
    <div class="page-content">
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            {{Form::open(['action' => 'Frontend\LoginController@doRegister', 'method' => 'POST', 'files' => true, 'id' => 'insert-admin', 'data-toggle'=>'validator'])}}
            {{--<h3 class="form-title text-center text-uppercase font-red">ĐĂNG KÝ</h3>--}}
            {{--<hr>--}}
            <br>
            @include("frontend.message")
            <div class="form-group">
                <a class="btn  btn-lg btn-block blue-steel"
                   href="{{URL::action("Frontend\LoginController@login_facebook")}}">
                    <span class="fa fa-facebook"></span> {{trans("index.dangnhapfacebook")}}
                </a>
            </div>
            <div class="form-group">
                <a class="btn btn-lg btn-block red" href="{{URL::action("Frontend\LoginController@google")}}">
                    <span class="fa fa-google-plus "></span> {{trans("index.dangnhapgoogle")}}
                </a>
            </div>
            <h3 class="form-title text-center text-uppercase font-red">{{trans("index.hoacdangkytkmoi")}} </h3>
            <hr>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span>  </span>
            </div>
            <div class="form-group">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <input class="input-lg  form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
                       placeholder="Email" name="email" required/>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9"> {{trans("index.matkhau")}}</label>
                <input class="input-lg  form-control form-control-solid placeholder-no-fix" type="password"
                       autocomplete="off"
                       placeholder="{{trans("index.matkhau")}}" name="password" required/>
            </div>
            {{--<div class="form-group">--}}
            {{--<label class="control-label visible-ie8 visible-ie9">Nhập lại mật khẩu</label>--}}
            {{--<input class=" form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Nhập lại mật khẩu" name="repassword" required />--}}
            {{--</div>--}}

            {{--<div class="form-group">--}}
            {{--<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->--}}
            {{--<label class="control-label visible-ie8 visible-ie9">Họ & tên</label>--}}
            {{--<input class=" form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Họ & tên" name="name" required />--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
            {{--<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->--}}
            {{--<label class="control-label visible-ie8 visible-ie9">Điện thoại</label>--}}
            {{--<input class=" form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Điện thoại" name="phone" required />--}}
            {{--</div>--}}
            <div class="form-actions">
                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="remember" value="1" required checked/>
                    {!! trans("index.toidongydieukhoan") !!}
                    {{--Tôi đồng ý với--}}
                    {{--<a href="javascript:;" id="forget-password" class="forget-password">điều khoản </a> của website--}}
                    <span></span>
                </label>
            </div>

            {{--<div class="form-group g-recaptcha" data-sitekey="{{ config('app.RE_CAP_SITE') }}"></div>--}}
            <div class="form-group text-center">
                {!! captcha_img() !!}
            </div>

            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9"> {{trans("index.captcha")}}</label>
                <input class="input-lg  form-control form-control-solid placeholder-no-fix" type="text"
                       autocomplete="off" placeholder="{{trans("index.captcha")}}" name="captcha" required/>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-lg green uppercase">{{trans("index.dangky")}}</button>
            </div>
            <div>

                {{--<ul class="social-icons">--}}
                {{--<li>--}}
                {{--<a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>--}}
                {{--</li>--}}
                {{--</ul>--}}
            </div>
            <hr>
            <div class="create-account">
                <p>
                    <a href="{{URL::action("Frontend\LoginController@login")}}" id="register-btn"
                       class="btn btn-block default btn-lg uppercase"> {{trans("index.quaylaitrangdangnhap")}}</a>
                </p>
            </div>
            {{Form::close()}}
        </div>
    </div>

</div>
@endsection