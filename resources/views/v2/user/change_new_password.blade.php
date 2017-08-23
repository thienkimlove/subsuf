@extends('v2.template')

@section('breadcrumb')
    {{--<div class="container">--}}
    {{--<!-- BEGIN PAGE BREADCRUMBS -->--}}
    {{--<ul class="page-breadcrumb breadcrumb">--}}
    {{--<li>--}}
    {{--<a href="index.html">Home</a>--}}
    {{--<i class="fa fa-circle"></i>--}}
    {{--</li>--}}
    {{--<li>--}}
    {{--<span>Layouts</span>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
@endsection

@section('content')

    <div class="content">
        <!-- BEGIN LOGIN FORM -->
        {{Form::open(['action' => 'Frontend\LoginController@doChangeNewPassword', 'method' => 'POST',  'id' => 'insert-admin', 'data-toggle'=>'validator'])}}
        <h3 class="form-title text-center text-uppercase font-red">{{trans("index.doimatkhau")}}</h3>
        {{--<hr>--}}
        <br>
        @include("frontend.message")
        <input type="hidden" name="code" value="{{$code}}">
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{trans("index.doimatkhau")}} </label>
            <input class="input-lg form-control form-control-solid placeholder-no-fix" type="password"
                   autocomplete="off" minlength="6" placeholder="{{trans("index.doimatkhau")}} " name="password"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">{{trans("index.matkhaunhaplai")}} </label>
            <input class="input-lg form-control form-control-solid placeholder-no-fix" type="password"
                   autocomplete="off" minlength="6" placeholder="{{trans("index.matkhaunhaplai")}} " name="repassword"/>
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-lg green uppercase">{{trans("index.doimatkhau")}}</button>

        </div>

    </div>
    {{Form::close()}}
@endsection

@section('script')

@endsection