@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/pages/css/profile.min.css')}}
    <style>
        .form-control {
            width: 100%;
            height: 34px;
            padding: 0 12px;
            /* background-color: #fff; */
            border: none;
            color: #000000;
        }
    </style>
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
                             @else src="{{$account->avatar}}"
                             @endif class="img-responsive" alt="">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> {{$account->first_name . ' ' . $account->last_name}}</div>
                        <div class="profile-usertitle-job">Từ: {{ucfirst($account->account_type)}}</div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li>
                                <a href="{{URL::action('Admin\AccountController@info', $account->account_id)}}">
                                    <i class="icon-home"></i> Tài khoản </a>
                            </li>
                            <li class="active">
                                <a href="#">
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
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="fa fa-credit-card font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Tài khoản nội địa</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                @if(count($account->payment_cards) <= 0)
                                    <div class="row">
                                        <div class="col-md-12 text-center font-grey-silver bold font-14">
                                            Chưa có thông tin
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12">
                                            @foreach($account->payment_cards as $card)
                                                <div class="well" style="font-size: 12px">
                                                    <div class="row">
                                                        <div class="col-xs-4">Quốc gia</div>
                                                        <div class="col-xs-8">{{$card->country_of_bank}}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">Ngân hàng</div>
                                                        <div class="col-xs-8 bold">{{$card->bank_name}}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">Chi nhánh</div>
                                                        <div class="col-xs-8 bold">{{$card->bank_department}}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">Số TK</div>
                                                        <div class="col-xs-8 bold">{{$card->account_number}}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">Chủ TK</div>
                                                        <div class="col-xs-8 bold">{{$card->name}}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-4">Swift Code</div>
                                                        <div class="col-xs-8">{{$card->swift_code}}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption caption-md">
                                            <i class="fa fa-paypal font-green"></i>
                                            <span class="caption-subject font-green bold uppercase">Tài khoản Paypal</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        @if(count($account->paypals) <= 0)
                                            <div class="row">
                                                <div class="col-md-12 text-center font-grey-silver bold font-14">
                                                    Chưa có thông tin
                                                </div>
                                            </div>
                                        @else
                                            @foreach($account->paypals as $paypal)
                                                <div class="well" style="font-size: 12px">
                                                    <div class="row">
                                                        <div class="col-xs-4">PayPal email:</div>
                                                        <div class="col-xs-8 bold">{{$paypal->paypal_email}}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>
            </div>
@endsection

@section('script')

@endsection