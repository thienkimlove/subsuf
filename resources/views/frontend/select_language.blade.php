<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>@if(isset($title)) {{$title}} @else Subsuf @endif</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    {{--{{Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')}}--}}
    {{Html::style('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}
    {{Html::style('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}
    {{Html::style('assets/global/css/components.min.css')}}
    {{Html::style('assets/global/css/plugins.min.css')}}

    {{Html::style('assets/layouts/layout3/css/layout.css')}}
    {{Html::style('assets/layouts/layout3/css/themes/default.min.css')}}
    {{Html::style('assets/layouts/layout3/css/custom.css')}}
    {{Html::favicon('/assets/subsuf_img/logo.png')}}

    <style>
        .glass {
            background: url("/images/index_fullsize_distr.jpg");
            height: 100%;
            width: 100%;
            background-size: cover;
            background-position-y: 10%;
            position: fixed;
            z-index: -1;
            -webkit-filter: blur(6px);
            filter: blur(6px);
        }

        .glass {
            width: 100%;
            height: 100%;
        }

        .glass::before {
            -webkit-filter: blur(5px);
            -o-filter: blur(5px);
            -moz-filter: blur(5px);
            filter: blur(5px);
        }

        .page-lock {
            top: 70%;
            left: 50%;
            width: 30%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.7);
            text-align: center;
            position: fixed;
            margin-top: -100px;
            margin-left: -15%;
        }
    </style>
</head>
<!-- END HEAD -->

<body>
<div class="glass">
</div>
<div style="position: relative; top: 5%; left: 5%">
    <img src="/assets/subsuf_img/logo.png" style="width: 90px">
</div>
<div class="hidden-lg hidden-md text-center" style="margin-top: 30%">
    {{Form::open(['action' => 'Frontend\IndexController@select_language', 'method' => 'POST', 'data-toggle'=>'validator'])}}

    <button style="min-width: 140px; width: 30%" type="submit" name="select_language" value="en"
            class="btn bold red btn-outline btn-lg text-uppercase">
        <p><img src="/images/united_kingdom_640.png" style="width: 80px"></p>
        English
    </button>
    &nbsp;
    &nbsp;
    &nbsp;
    <button style="min-width: 140px; width: 30%" type="submit" name="select_language" value="vi"
            class="btn red bold btn-outline btn-lg text-uppercase">
        <p><img src="/images/vietnam_640.png" style="width: 80px"></p>
        Tiếng việt
    </button>

    {{Form::close()}}
</div>
<div class="page-lock hidden-xs hidden-sm">
    <div class="page-body">
        <div class="page-lock-info">
            {{Form::open(['action' => 'Frontend\IndexController@select_language', 'method' => 'POST', 'data-toggle'=>'validator'])}}
            <p>
                <button style="min-width: 140px; width: 30%" type="submit" name="select_language" value="en"
                        class="btn bold red btn-outline btn-lg text-uppercase">
            <p><img src="/images/united_kingdom_640.png" style="width: 80px"></p>
            English
            </button>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            <button style="min-width: 140px; width: 30%" type="submit" name="select_language" value="vi"
                    class="btn red bold btn-outline btn-lg text-uppercase">
                <p><img src="/images/vietnam_640.png" style="width: 80px"></p>
                Tiếng việt
            </button>
            <p>

        </div>
        {{Form::close()}}
    </div>
</div>
</div>


{{Html::script('assets/global/plugins/respond.min.js')}}
{{Html::script('assets/global/plugins/excanvas.min.js')}}
{{Html::script('assets/global/plugins/jquery.min.js')}}
{{Html::script('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}
{{Html::script('assets/global/plugins/js.cookie.min.js')}}
{{Html::script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}
{{Html::script('assets/global/plugins/jquery.blockui.min.js')}}
{{Html::script('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}
{{Html::script('assets/global/scripts/app.min.js')}}
{{Html::script('assets/layouts/layout3/scripts/layout.js')}}
{{Html::script('assets/layouts/layout3/scripts/demo.min.js')}}
{{Html::script('assets/layouts/global/scripts/quick-sidebar.min.js')}}
{{Html::script('assets/pages/scripts/validator.min.js')}}
</body>

</html>
