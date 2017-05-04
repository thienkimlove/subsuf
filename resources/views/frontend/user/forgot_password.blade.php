@extends('frontend.layout.template')
@section('style')
    <link href="assets/pages/css/login.min.css" rel="stylesheet" type="text/css"/>
@endsection
@section('breadcrumb')

@endsection

@section('content')

    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        {{Form::open(['action' => 'Frontend\LoginController@sendEmailForgotPassword', 'method' => 'POST',  'id' => 'insert-admin', 'data-toggle'=>'validator'])}}
        <h3 class="form-title text-center text-uppercase font-red">{{trans("index.quenmatkhau")}}</h3>
        {{--<hr>--}}
        <br>
        @include("frontend.message")
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="input-lg form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
                   placeholder="Email" name="email"/>
        </div>


        <div class="form-group  text-center">
            <button type="submit" class="btn btn-lg red uppercase">{{trans("index.guiemail")}}</button>

        </div>

        <hr>
        <div class="create-account">
            <p>
                <a href="{{URL::action("Frontend\LoginController@login")}}" id="register-btn"
                   class="btn btn-block default  btn-lg uppercase">
                    {{trans("index.dangnhap")}}
                </a>
                <a href="{{URL::action("Frontend\LoginController@register")}}" id="register-btn"
                   class="btn btn-block default btn-lg uppercase">
                    {{trans("index.dangky")}}
                </a>
            </p>
        </div>
        {{Form::close()}}
    </div>
@endsection

@section('script')

@endsection