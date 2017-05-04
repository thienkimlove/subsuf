<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{{$title}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="{{$description}}" name="description"/>
    <meta content="" name="author"/>

    {{Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')}}
    {{Html::style('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}
    {{Html::style('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}
    {{Html::style('assets/global/css/components.min.css')}}
    {{Html::style('assets/global/css/plugins.min.css')}}
    {{Html::style('assets/pages/css/login.min.css')}}
    {{Html::favicon('/assets/subsuf_img/logo.png')}}
</head>
<body class=" login">

<div class="logo">
    <a href="#"><img src="/assets/subsuf_img/logo.png" style="max-width: 72px"> </a>
</div>

<div class="content">
    {!! Form::open(['action' => 'Admin\AccessController@login', 'method' => 'POST', 'class'=> 'login-form']) !!}
    <h3 class="form-title font-green">Đăng nhập</h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span> Vui lòng nhập tên tài khoản và mật khẩu. </span>
    </div>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Tên tài khoản</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
               placeholder="Tên tài khoản" name="username"/></div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Mật khẩu</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
               placeholder="Mật khẩu" name="password"/></div>
    <div class="form-actions text-center">
        <button type="submit" class="btn green uppercase">Đăng nhập</button>
    </div>
    {!! Form::close() !!}
</div>

{{--<div class="copyright"> 2014 © Metronic. Admin Dashboard Template.</div>--}}
{{Html::script('assets/global/plugins/jquery.min.js')}}
{{Html::script('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}
{{Html::script('assets/global/plugins/js.cookie.min.js')}}
{{Html::script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}
{{Html::script('assets/global/plugins/jquery.blockui.min.js')}}
{{Html::script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}
{{Html::script('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}
{{Html::script('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}
{{Html::script('assets/global/scripts/app.min.js')}}
{{Html::script('assets/pages/scripts/login.js')}}
<script>
    jQuery(document).ready(function () {
        @if (isset($status) && isset($message))
            $('.login-form').find('.alert span').text('{!! $message !!}');
        $('.login-form').find('.alert').show();
        @endif
    });
</script>
</body>

</html>