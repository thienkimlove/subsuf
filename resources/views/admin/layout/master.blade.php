<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
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
    <title>{{$title}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
{{Html::style("http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all")}}
{{Html::style("assets/global/plugins/font-awesome/css/font-awesome.min.css")}}
{{Html::style("assets/global/plugins/simple-line-icons/simple-line-icons.min.css")}}
{{Html::style("assets/global/plugins/bootstrap/css/bootstrap.min.css")}}
{{Html::style("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css")}}
<!-- END GLOBAL MANDATORY STYLES -->

@yield('style')
<!-- BEGIN THEME GLOBAL STYLES -->
{{Html::style("assets/global/css/components.min.css")}}
{{Html::style("assets/global/css/plugins.min.css")}}
<!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
{{Html::style("assets/layouts/layout/css/layout.min.css")}}
{{Html::style("assets/layouts/layout/css/themes/darkblue.min.css")}}
{{Html::style("assets/layouts/layout/css/custom.min.css")}}
{{Html::style('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}
<!-- END THEME LAYOUT STYLES -->
    {{Html::favicon('/assets/subsuf_img/logo.png')}}
</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="{{URL::action('Admin\AdminDasboardController@index')}}">
                    <img src="/assets/subsuf_img/logo.png" style="max-width: 36px; margin-top: 7px;" alt="logo"
                         class=""/> </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
               data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <?php $admin = get_admin_session(); ?>
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle" src="{{get_avatar()}}"/>
                            <span class="username username-hide-on-mobile"> {{($admin != null) ? $admin->name : ''}} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{($admin != null) ? URL::action('Admin\AdminController@info', $admin->admin_id) : "#"}}">
                                    <i class="icon-user"></i> Thông tin </a>
                            </li>
                            <li>
                                <a href="{{URL::action('Admin\AdminController@change_password')}}">
                                    <i class="icon-key"></i> Đổi mật khẩu </a>
                            </li>
                            <li>
                            {{--<a href="app_inbox.html">--}}
                            {{--<i class="icon-envelope-open"></i> My Inbox--}}
                            {{--<span class="badge badge-danger"> 3 </span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<a href="app_todo.html">--}}
                            {{--<i class="icon-rocket"></i> My Tasks--}}
                            {{--<span class="badge badge-success"> 7 </span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            <li class="divider"></li>
                            {{--<li>--}}
                            {{--<a href="page_user_lock_1.html">--}}
                            {{--<i class="icon-lock"></i> Lock Screen </a>--}}
                            {{--</li>--}}
                            <li>
                                <a href="{{URL::action('Admin\AccessController@logout')}}">
                                    <i class="icon-logout"></i> Đăng xuất </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"></div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
                @include("admin.layout.menu")
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper page-container-bg-solid">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">

                <div class="page-bar">
                    @yield('page-breadcrumb')
                    @yield('page-toolbar')
                </div>
                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
            @yield('pagetitle')
            <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->
                <div class="row">
                    <div class="col-lg-12 hidden-print" style="margin-top: 5px">
                        <div class="alert-box">

                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>

        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner"> 2016 &copy; Subsuf.com

        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
</div>
<!--[if lt IE 9]>
{{Html::script("assets/global/plugins/respond.min.js")}}
{{Html::script("assets/global/plugins/excanvas.min.js")}}
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
{{Html::script("assets/global/plugins/jquery.min.js")}}
{{Html::script("assets/global/plugins/bootstrap/js/bootstrap.min.js")}}
{{Html::script("assets/global/plugins/js.cookie.min.js")}}
{{Html::script("assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js")}}
{{Html::script("assets/global/plugins/jquery.blockui.min.js")}}
{{Html::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")}}
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
{{Html::script("assets/global/scripts/app.min.js")}}
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
{{Html::script("assets/layouts/layout/scripts/layout.min.js")}}
{{Html::script("assets/layouts/layout/scripts/demo.min.js")}}
{{Html::script("assets/layouts/global/scripts/quick-sidebar.min.js")}}
{{Html::script('assets/pages/scripts/admin-custom.js')}}
{{Html::script('assets/global/plugins/bootstrap-toastr/toastr.min.js')}}

<script>
    @if (Session::has('success'))
    $(document).ready(function () {
        toastr.options.closeButton = true;
        toastr.success('{{ Session::get('success')}}', 'Thông báo');
    });
    @elseif (Session::has('error'))
    $(document).ready(function () {
        App.alert({
            container: '.alert-box',
            place: 'append',
            type: 'danger',
            message: '{{ Session::get('error')}}',
            close: true,
            reset: true,
            focus: true,
        });
    });
    @endif
</script>

@yield('script')
<!-- END THEME LAYOUT SCRIPTS -->
</body>