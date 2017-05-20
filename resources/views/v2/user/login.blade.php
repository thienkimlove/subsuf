


@extends('v2.template')

@section('content')
<div class="wrap_container">
    <div class="page-content">
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            {{Form::open(['action' => 'Frontend\LoginController@doLogin', 'method' => 'POST',  'id' => 'insert-admin', 'data-toggle'=>'validator'])}}

                <br>
            @include("frontend.message")
            <div class="form-group">
                <div class="form-group">
                    <a class="btn  btn-lg btn-block blue-steel"
                       href="{{URL::action("Frontend\LoginController@login_facebook")}}">
                        <span class="fa fa-facebook"></span>{{trans("index.dangnhapfacebook")}}
                    </a>
                </div>
                <div class="form-group">
                    <a class="btn btn-lg btn-block red" href="{{URL::action("Frontend\LoginController@google")}}">
                        <span class="fa fa-google-plus "></span>{{trans("index.dangnhapgoogle")}}
                    </a>
                </div>
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <input class="input-lg form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
                       placeholder="Email" name="email"/></div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">{{trans("index.matkhau")}} </label>
                <input class="input-lg form-control form-control-solid placeholder-no-fix" type="password"
                       autocomplete="off" placeholder="{{trans("index.matkhau")}} " name="password"/></div>
            <div class="form-actions">
                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="remember_me" value="1"/>{{trans("index.ghinho")}}
                    <span></span>
                </label>
                <a href="{{URL::action("Frontend\LoginController@forgotPassword")}}" style="float: right;" id="forget-password" class="forget-password">{{trans("index.quenmatkhau")}}?</a>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-lg green uppercase">{{trans("index.dangnhap")}}</button>

            </div>

            <hr>
            <div class="create-account">
                <p>
                    <a href="{{URL::action("Frontend\LoginController@register")}}" id="register-btn" class="btn btn-block default btn-lg uppercase">{{trans("index.dangky")}}</a>
                </p>
            </div>
            {{Form::close()}}
        </div>
    </div>

</div>
    @endsection
