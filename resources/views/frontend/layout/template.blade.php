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
    <meta property="og:url" content="http://sufsub.com/register"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Get any items from overseas by travelers on the way to Vietnam."/>
    <meta property="og:description"
          content="Dịch vụ mua hàng nước ngoài tiết kiệm,mua và chuyển tới trực tiếp bởi những người sắp đến Việt Nam."/>
    <meta property="og:image" content="http://subsuf.com/images/sufsub.jpg"/>
    <meta charset="utf-8"/>
    {{--{{Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all')}}--}}
    {{Html::style('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}
    {{Html::style('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}
    {{Html::style('assets/global/css/components.min.css')}}
    {{Html::style('assets/global/css/plugins.min.css')}}
    @yield('style','')
    {{Html::style('assets/layouts/layout3/css/layout.css')}}
    {{Html::style('assets/layouts/layout3/css/themes/default.min.css')}}
    {{Html::style('assets/layouts/layout3/css/custom.css')}}
    {{Html::favicon('/assets/subsuf_img/logo.png')}}
    <style>
        .header-menu a {
            color: #666 !important;
            text-transform: none !important;
            font-size: 18px;
            font-weight: 500;
        }

        .page-header .page-header-top .top-menu .navbar-nav > li.dropdown {
            font-size: 18px;
        }
    </style>
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-header-top-fixed">
<div class="page-wrapper">
    <div class="page-wrapper-row">
        <div class="page-wrapper-top">
            <!-- BEGIN HEADER -->
            <div class="page-header">
                <!-- BEGIN HEADER TOP -->
                <div class="page-header-top">
                    <div class="container-fluid">
                        <!-- BEGIN LOGO -->
                        <div class="page-logo hidden-xs hidden-sm">
                            <a href="{{URL::action('Frontend\IndexController@index')}}">
                                <img src="/assets/subsuf_img/logo.png"
                                     style="max-width: 65px; padding: 5px; margin-top: 5px">
                            </a>
                        </div>
                        <div class="top-menu" style="float: left;">
                            <ul class="nav navbar-nav header-menu dropdown">
                                <li class="hidden-lg hidden-md "><a
                                            href="{{URL::action('Frontend\IndexController@index')}}">
                                        <img src="/assets/subsuf_img/logo.png"
                                             style="max-width: 40px; margin-top: 5px">
                                    </a>
                                </li>
                                <li class="dropdown top-menu-item" style="">
                                    <a href="{{URL::action('Frontend\ShopperController@index')}}"
                                       class="dropdown-toggle" style=" margin-top: 2px;">
                                        <strong class="show-mobile hidden-sm  hidden-md  hidden-lg">
                                            <i class="icon-bag fa-2x font-dark"></i>
                                        </strong>
                                        <strong class=" hidden-xs"><i class="icon-bag"></i>
                                            <span>{{trans('index.muagiodau')}}</span>
                                        </strong>
                                        {{--<span class="badge badge-default">3</span>--}}
                                    </a>
                                </li>
                                <li class="dropdown  top-menu-item" style="">
                                    <a href="{{URL::action('Frontend\TravelerController@index')}}"
                                       class="dropdown-toggle" style="padding: 10px; margin-top: 2px;">
                                        <strong class="show-mobile hidden-sm  hidden-md  hidden-lg"><i
                                                    class="icon-plane font-dark "></i></strong>
                                        <strong class=" hidden-xs"><i class="icon-plane"></i>
                                            <span>{{trans('index.nhanmuaho')}}</span></strong>
                                        {{--<span class="badge badge-default">3</span>--}}
                                    </a>
                                </li>
                            @if(Session::has("userFrontend"))
                                <?php
                                $notifications = Session::get("userFrontend")->notifications()->unread()->get();
                                $unread = count($notifications);
                                ?>
                                <!-- BEGIN NOTIFICATION DROPDOWN -->
                                    <li class="dropdown dropdown-extended dropdown-notification hidden-lg hidden-md"
                                        style="margin-top: 15px;"
                                        id="header_notification_bar">
                                        <a href="{{URL::action('Frontend\NotificationController@user_notification',
                                                Session::get("userFrontend")->account_id)}}" class="dropdown-toggle">
                                            <i class="icon-bell" style="color: #c1ccd1 !important"></i>
                                            @if($unread > 0)
                                                <span class="badge badge-default">
                                                    {{$unread}}
                                                </span>
                                            @endif
                                        </a>
                                        <ul class="dropdown-menu">

                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <!-- END LOGO -->
                        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                        <a href="javascript:;" class="menu-toggler" style="margin-top:13px"></a>
                        <!-- END RESPONSIVE MENU TOGGLER -->

                        <!-- BEGIN TOP NAVIGATION MENU -->
                        <div class="top-menu hidden-xs hidden-sm">
                            <ul class="nav navbar-nav pull-right">
                                {{--<li class="dropdown">--}}
                                {{--<a class="font-dark dropdown-toggle" href="#"--}}
                                {{--style="padding: 10px; margin-top: 2px;">--}}
                                {{--<strong>Blog</strong>--}}
                                {{--</a>--}}
                                {{--</li>--}}
                                @if(Session::has("userFrontend"))
                                    <li>
                                        <a href="@if(count(Session::get("userFrontend")->payment_cards) > 0 || count(Session::get("userFrontend")->paypals) > 0)
                                        {{URL::action('Frontend\TravelerController@index')}}
                                        @else
                                        {{URL::action("Frontend\UserController@paymentInfo")}}
                                        @endif" class="btn red"
                                           style="padding: 10px; margin-top: 2px;">
                                            <strong>{{trans("index.trothanhnguoimuaho")}}</strong>
                                        </a>
                                    </li>
                                @else
                                    <li><a href="{{URL::action("Frontend\LoginController@register")}}" class="btn red"
                                           style="padding: 10px; margin-top: 2px;">
                                            <strong>{{trans("index.trothanhnguoimuaho")}}</strong>
                                        </a>
                                    </li>
                                @endif
                                @if(!Session::has("userFrontend"))
                                    <li class="dropdown">
                                        <a class="font-dark dropdown-toggle" style="padding: 10px; margin-top: 2px;"
                                           href="{{URL::action("Frontend\LoginController@register")}}">
                                            <strong>{{trans("index.dangky")}}</strong>
                                        </a>
                                    </li>
                                    <li class="dropdown">
                                        <a class="font-dark dropdown-toggle" style="padding: 10px; margin-top: 2px;"
                                           href="{{URL::action("Frontend\LoginController@login")}}">
                                            <strong>{{trans("index.dangnhap")}}</strong>
                                        </a>
                                    </li>
                                @endif


                                @if(Session::has("userFrontend"))
                                    <?php
                                    $notifications = Session::get("userFrontend")->notifications()->unread()->get();
                                    $unread = count($notifications);
                                    ?>
                                <!-- BEGIN NOTIFICATION DROPDOWN -->
                                    <li class="dropdown dropdown-extended dropdown-notification "
                                        id="header_notification_bar">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                           data-hover="dropdown" data-close-others="true">
                                            <i class="icon-bell"></i>
                                            @if($unread > 0)
                                                <span class="badge badge-default">
                                                    {{$unread}}
                                                </span>
                                            @endif
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="external">
                                                @if((int)$unread>1)
                                                    <h3>{!! trans('index.bancotinnhan_n', ['number' => $unread]) !!}</h3>
                                                @else
                                                    <h3>{!! trans('index.bancotinnhan', ['number' => $unread]) !!}</h3>
                                                @endif
                                                <a href="{{URL::action('Frontend\NotificationController@user_notification',
                                                Session::get("userFrontend")->account_id)}}">
                                                    {{trans("index.xemtatca")}}
                                                </a>
                                            </li>

                                            {{--<li>--}}
                                            {{--<ul class="dropdown-menu-list scroller" style="height: 250px;"--}}
                                            {{--data-handle-color="#637283">--}}
                                            {{--@foreach(Session::get("userFrontend")->notifications()->unread()->get() as $notification)--}}
                                            {{--<li>--}}
                                            {{--<a href="javascript:;">--}}
                                            {{--<span class="time">--}}
                                            {{--{{date('d-m-Y', strtotime($notification->sent_at))}}--}}
                                            {{--</span>--}}
                                            {{--<span class="details">--}}
                                            {{--{{$notification->content_vi}}--}}
                                            {{--</span>--}}
                                            {{--</a>--}}
                                            {{--</li>--}}
                                            {{--@endforeach--}}
                                            {{--</ul>--}}
                                            {{--</li>--}}
                                        </ul>
                                    </li>

                                    <li class="droddown dropdown-separator">
                                        <span class="separator"></span>
                                    </li>

                                    <!-- BEGIN USER LOGIN DROPDOWN -->
                                    <li class="dropdown dropdown-user">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                           data-hover="dropdown" data-close-others="true">
                                            <img alt="" class="img-circle"
                                                 src="{{URL::to(Session::get("userFrontend")->avatar)}}">
                                            <span class="username font-dark username-hide-mobile">
                                                <b>{{Session::get("userFrontend")->first_name." ".Session::get("userFrontend")->last_name}}</b>
                                            </span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-default">
                                            <li>
                                                <a href="{{URL::action("Frontend\UserController@profile")}}">
                                                    <i class="icon-user"></i> {{trans("index.thongtintaikhoan")}}</a>
                                            </li>

                                            <li>
                                                <a href="{{URL::action("Frontend\LoginController@logout")}}">
                                                    <i class="icon-key"></i> {{trans("index.dangxuat")}} </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif

                            </ul>
                        </div>
                        <!-- END TOP NAVIGATION MENU -->
                    </div>
                </div>
                <!-- END HEADER TOP -->
                <!-- BEGIN HEADER MENU -->
                <div class="page-header-menu">
                    <div class="container">
                        <!-- BEGIN HEADER SEARCH BOX -->
                    {{--<form class="search-form" action="page_general_search.html" method="GET">--}}
                    {{--<div class="input-group">--}}
                    {{--<input type="text" class="form-control" placeholder="Search" name="query">--}}
                    {{--<span class="input-group-btn">--}}
                    {{--<a href="javascript:;" class="btn submit">--}}
                    {{--<i class="icon-magnifier"></i>--}}
                    {{--</a>--}}
                    {{--</span>--}}
                    {{--</div>--}}
                    {{--</form>--}}
                    <!-- END HEADER SEARCH BOX -->
                        <!-- BEGIN MEGA MENU -->
                        <div class="hor-menu  margin-bottom-20">
                            <ul class="nav navbar-nav">

                                {{--<li class="dropdown">--}}
                                {{--<a class="font-dark dropdown-toggle" href="#"--}}
                                {{--style="padding: 10px; margin-top: 2px;">--}}
                                {{--<strong>Blog</strong>--}}
                                {{--</a>--}}
                                {{--</li>--}}
                                @if(!Session::has("userFrontend"))
                                    <li class="dropdown">
                                        <a class="font-dark dropdown-toggle" style="padding: 10px; margin-top: 2px;"
                                           href="{{URL::action("Frontend\LoginController@register")}}">
                                            <strong>{{trans("index.dangky")}}</strong>
                                        </a>
                                    </li>
                                    <li class="dropdown">
                                        <a class="font-dark dropdown-toggle" style="padding: 10px; margin-top: 2px;"
                                           href="{{URL::action("Frontend\LoginController@login")}}">
                                            <strong>{{trans("index.dangnhap")}}</strong>
                                        </a>
                                    </li>
                                @else
                                    <li class="dropdown dropdown-user">
                                        <a href="{{URL::action("Frontend\UserController@profile")}}"
                                        >
                                            <img alt="" class="img-circle" style="max-width: 40px"
                                                 src="{{URL::to(Session::get("userFrontend")->avatar)}}">
                                            <span class="username font-dark username-hide-mobile">
                                                <b>
                                                    @if(Lang::locale()=="vi")
                                                        {{Session::get("userFrontend")->first_name." ".Session::get("userFrontend")->last_name}}
                                                    @else
                                                        {{Session::get("userFrontend")->last_name." ".Session::get("userFrontend")->first_name}}
                                                    @endif
                                                </b>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="{{URL::action("Frontend\LoginController@logout")}}">
                                            <i class="icon-key"></i>{{trans("index.dangxuat")}}</a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                        <!-- END MEGA MENU -->
                    </div>
                </div>
                <!-- END HEADER MENU -->
            </div>
            <!-- END HEADER -->
        </div>
    </div>
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper"><!-- BEGIN HEADER TOP -->
                    <!-- BEGIN CONTENT BODY -->

                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="page-content">
                        @yield('breadcrumb','')

                        @yield('content','')
                    </div>
                    <!-- END PAGE CONTENT BODY -->
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
        </div>
    </div>
    <div class="page-wrapper-row">
        <div class="page-wrapper-bottom">
            <!-- BEGIN FOOTER -->
            <!-- BEGIN PRE-FOOTER -->
            <style>
                .footer-menu {
                    font-size: 10px;
                }

                .footer-menu a {
                    font-size: 14px;
                    padding: 5px 10px;
                    display: inline-block;
                }

                .social-icon-list {
                    margin-top: 20px;
                }

                .social-icon-list a {
                    display: inline-block;
                    margin: 5px;
                }
            </style>
            <div class="page-prefooter">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center font-white uppercase footer-menu">
                            <a class=" font-white"
                               href="{{URL::action('Frontend\BlogController@index')}}">{{trans("index.blog")}}</a>
                            |
                            <a class=" font-white"
                               href="{{URL::action('Admin\StaticContentController@get_about')}}">{{trans("index.vechungtoi")}}</a>
                            |
                            <a class=" font-white"
                               href="{{URL::action('Admin\FaqController@get_faq')}}">{{trans("index.cauhoithuonggap")}}</a>
                            |
                            <a class=" font-white"
                               href="{{URL::action('Admin\StaticContentController@get_term')}}">{{trans("index.dieukhoansudung")}}</a>
                            |
                            <a class=" font-white"
                               href="{{URL::action('Admin\StaticContentController@get_policy')}}">{{trans("index.chinhsachbaomat")}}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center font-white uppercase social-icon-list"
                             style="margin-top: 20px">
                            <a href="https://www.facebook.com/Subsuf.global/?ref=aymt_homepage_panel" target="_blank"
                               class="btn btn-lg blue-sharp"><i class="fa fa-facebook"></i> </a>
                            <a href="/" class="btn btn-lg blue" target="_blank"><i class="fa fa-linkedin"></i> </a>
                            <a href="https://www.youtube.com/channel/UCDNkaXLEvRmS1i1_JLAhSIw"
                               class="btn btn-lg red-mint" target="_blank"><i class="fa fa-youtube"></i> </a>
                            <br>
                            <br>
                            <p>
                            <address class="margin-bottom-10"> {{trans("index.dienthoai")}}
                                : {{trans("index.number_phone")}}
                                <br> Email:
                                <a href="mailto:info@subsuf.com">support@subsuf.com</a>
                            </address>
                            </p>
                            <p>
                                <a href="{{URL::action('Frontend\IndexController@change_language') . "?language=en"}}">
                                    <img src="/images/united_kingdom_640.png" width="50px"></a>
                                <a href="{{URL::action('Frontend\IndexController@change_language') . "?language=vi"}}">
                                    <img src="/images/vietnam_640.png" width="50px"></a>
                            </p>
                        </div>

                    </div>
                    <div class="row text-center">
                        <hr class="border-blue-oleo">
                        <p>{{trans("index.copyright")}} </p>
                        {{--<div class="col-md-3 col-sm-6 col-xs-12 footer-block text-center">--}}
                        {{--<h2 class="font-red">Subsuf</h2>--}}
                        {{--<p><a href="{{URL::action('Frontend\IndexController@index')}}">--}}
                        {{--<img src="/assets/subsuf_img/logo.png"--}}
                        {{--style="max-width: 65px; padding: 5px; margin-top: 5px">--}}
                        {{--</a>--}}
                        {{--</p>--}}
                        {{--<br>--}}

                        {{--</div>--}}
                        <div class="col-md-3 col-sm-6 col-xs12 footer-block">
                            {{--<a href="{{URL::action('Admin\StaticContentController@get_about')}}">--}}
                            {{--<h2 class="font-red" style="color: #fff !important; font-size: 13px">--}}
                            {{--<i class="fa fa-caret-right"></i>--}}
                            {{--{{trans("index.blog")}}--}}
                            {{--</h2>--}}
                            {{--</a>--}}
                            {{--<a href="{{URL::action('Admin\StaticContentController@get_about')}}">--}}
                            {{--<h2 class="font-red" style="color: #fff !important; font-size: 13px">--}}
                            {{--<i class="fa fa-caret-right"></i>--}}
                            {{--{{trans("index.vechungtoi")}}--}}
                            {{--</h2>--}}
                            {{--</a>--}}
                            {{--<a href="{{URL::action('Admin\FaqController@get_faq')}}">--}}
                            {{--<h2 class="font-red" style="color: #fff !important; font-size: 13px">--}}
                            {{--<i class="fa fa-caret-right"></i>--}}
                            {{--{{trans("index.cauhoithuonggap")}}--}}
                            {{--</h2>--}}
                            {{--</a>--}}
                            {{--<a href="{{URL::action('Admin\StaticContentController@get_term')}}">--}}
                            {{--<h2 class="font-red" style="color: #fff !important; font-size: 13px">--}}
                            {{--<i class="fa fa-caret-right"></i>--}}
                            {{--{{trans("index.dieukhoansudung")}}--}}
                            {{--</h2>--}}
                            {{--</a>--}}
                            {{--<a href="{{URL::action('Admin\StaticContentController@get_policy')}}">--}}
                            {{--<h2 class="font-red" style="color: #fff !important; font-size: 13px">--}}
                            {{--<i class="fa fa-caret-right"></i>--}}
                            {{--{{trans("index.chinhsachbaomat")}}--}}
                            {{--</h2>--}}
                            {{--</a>--}}

                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 footer-block">
                            {{--<h2 class="font-red">{{trans("index.ngonngu")}}</h2>--}}


                        </div>
                    </div>
                </div>
            </div>
            <!-- END PRE-FOOTER -->
        {{--<!-- BEGIN INNER FOOTER -->--}}
        {{--<div class="page-footer">--}}
        {{--<div class="container"> 2016 &copy; Subsuf--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="scroll-to-top">--}}
        {{--<i class="icon-arrow-up"></i>--}}
        {{--</div>--}}
        {{--<!-- END INNER FOOTER -->--}}
        <!-- END FOOTER -->
        </div>
    </div>
</div>
@include('frontend.coupon_get')
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
{{Html::script('assets/apps/scripts/cookie.js')}}
<!--[if lt IE 9]>

<![endif]-->
@yield('script','')

<!-- CHAT -->
<script lang="javascript">
    (function () {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            // You are in mobile browser
        } else {
            var pname = ( (document.title != '') ? document.title : document.querySelector('h1').innerHTML );
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.src = '//live.vnpgroup.net/js/web_client_box.php?hash=ceff237de05fbccd93e18adb9e598967&data=eyJzc29faWQiOjQ0MjA4NTIsImhhc2giOiI3MmY0ZDg5M2JmZjgwNTZjMzJmY2EwYWU4NGU1ZmJiMyJ9&pname=' + pname;
            var s = document.getElementsByTagName('script');
            s[0].parentNode.insertBefore(ga, s[0]);
        }
    })();
</script>
<script>
    var url = '{{ url('/') }}';

    function couponSubmit() {
        var email = $('#coupon_email').val();
        $.get(url +'/promotion_coupon',{ email : email },function(response){
              $('#coupon_message').show().text(response.msg);
        });
    }

   $(function(){

       var isShowing = Cookies.get('show_popup_secure', { domain : document.domain });

       if (!isShowing || isShowing === '0') {
           $('#coupon_popup').modal();
           Cookies.set('show_popup_secure', '1', { expires: 7, domain: document.domain });

       }


       $('#coupon_submit').click(function(){
           couponSubmit();
           return false;
       });



   });
</script>
</body>

</html>