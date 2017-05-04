@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/pages/css/profile.min.css')}}
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Quản lý Người dùng</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\AccountController@index')}}">Tài khoản</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thông tin: {{$account->email}}</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered " style="padding-bottom: 0 !important;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user font-green"></i>
                        <span class="caption-subject font-green bold">Tài khoản: {{$account->email}}</span>
                    </div>

                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang Tài khoản người dùng"
                           href="{{URL::action('Admin\AccountController@index')}}">
                            <i class="fa fa-undo"></i>
                        </a>

                        @if($account->account_status == 1)
                            <a type="button" class="btn btn-xs red tooltips m-r-0"
                               title="Tạm dừng tài khoản"
                               onclick="return confirm('Tạm dừng tài khoản {{$account->email}}?');"
                               href="{{URL::action('Admin\AccountController@ban', $account->account_id)}}">
                                <i class="fa fa-ban"></i>
                            </a>
                        @endif

                        @if($account->account_status == -1)
                            <a type="button" class="btn btn-xs green tooltips m-r-0"
                               title="Kích hoạt tài khoản"
                               onclick="return confirm('Kích hoạt tài khoản {{$account->email}}?');"
                               href="{{URL::action('Admin\AccountController@active', $account->account_id)}}">
                                <i class="fa fa-check"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class="portlet light profile-sidebar-portlet ">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <img @if($account->avatar == '') src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                             @else src="{{$account->avatar}}" @endif class="img-responsive" alt=""
                             style="max-width: 300px">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            <span class="full-name">
                                {{$account->first_name . ' ' . $account->last_name}}
                            </span>
                        </div>
                        <div class="profile-usertitle-job">Từ: {{ucfirst($account->account_type)}}</div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li class="active">
                                <a href="#">
                                    <i class="icon-home"></i> Tài khoản </a>
                            </li>
                            <li>
                                <a href="{{URL::action('Admin\AccountController@payment_info', $account->account_id)}}">
                                    <i class="fa fa-university"></i> Thanh toán </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END MENU -->
                </div>
                <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->

            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PORTLET -->
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="icon-bar-chart theme-font hide"></i>
                                    <span class="caption-subject font-green bold uppercase">Thông tin tài khoản</span>
                                    <span class="caption-helper hide">weekly stats...</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table">
                                    <tr>
                                        <td width="30%">Tên:</td>
                                        <td>{{$account->first_name . ' ' . $account->last_name}}</td>
                                    </tr>

                                    <tr>
                                        <td>Email:</td>
                                        <td class="bold">
                                            {{$account->email}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Xác thực email:</td>
                                        <td class="{{$email_status[$account->is_verified]['class']}}">
                                            {{$email_status[$account->is_verified]['name']}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Điện thoại:</td>
                                        <td>
                                            {{substr($account->phone_number, 0 , 3) . ' ' .
                                            substr($account->phone_number, 3 , 3) . ' ' .
                                            substr($account->phone_number, 6)}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Trạng thái:</td>
                                        <td class="{{$account_status[$account->account_status]['class']}}">
                                            {{$account_status[$account->account_status]['name']}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Mã chia sẻ:</td>
                                        <td>{{$account->share_code}}</td>
                                    </tr>

                                    @if($account->from_account_id != 0)
                                        <tr>
                                            <td>Người mời:</td>
                                            <td>
                                                <a href="{{URL::action('Admin\AccountController@info', $account->account->account_id)}}">
                                                    {{$account->account->email}}
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- END PORTLET -->
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
@endsection

@section('script')

@endsection