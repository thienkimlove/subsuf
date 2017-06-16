@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/sliderengine/amazingslider-1.css')}}
    {{Html::style('assets/pages/css/profile.min.css')}}

    <style>
        .amazingslider-box-1 {
            margin-left: 0 !important;
        }

        .table.order-detail td {
            font-size: 13px !important;
            color: #000000 !important;
        }

        .table.order-detail td.highlight {
            color: #32C5D2 !important;
        }

        .none {
            text-decoration: none !important;
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
            <a href="{{URL::action('Admin\OrderController@index')}}">Quản lý Order</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thông tin: Order #{{$order->code}}</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">

        </div>
    </div>
@endsection

@section('pagetitle')

@endsection

@section('content')
    <h1 class="page-title">
    </h1>

    <div class="row">
        <div class="col-xs-12 col-md-7 col-lg-6 offset-lg-1">
            <div class="portlet light">
                <p></p>
                <div class="portlet-body">
                    <div id="amazingslider-wrapper-1" class="text-center"
                         style="display:block;position:relative;max-width:300px;margin:0 auto 86px;">
                        <div id="amazingslider-1" style="display:block;position:relative;margin:0 auto;">
                            <ul class="amazingslider-slides" style="display:none;">
                                @foreach($order->order_images as $image)
                                    <li>
                                        <img src="{{$image->image}}" alt="" title=""/>
                                    </li>
                                @endforeach
                            </ul>
                            <hr>
                            <ul class="amazingslider-thumbnails" style="display:none;">
                                @foreach($order->order_images as $image)
                                    <li>
                                        <img src="{{$image->image}}" alt="" title=""/>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <hr style="margin:0">
                    <div class="panel" style="border-radius: 5px">
                        <h4 class="text-break-word bold">{{$order->name}}</h4>
                        <p class="text-break-word m-b-0">{{$order->description}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-5 col-lg-6">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart font-green"></i>
                        <span class="caption-subject font-green bold uppercase">
                            Order #{{$order->code}}
                        </span>
                    </div>

                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang Order"
                           href="{{URL::action('Admin\OrderController@index')}}">
                            <i class="fa fa-undo"></i>
                        </a>
                    </div>
                </div>

                <div class="body">
                    <a class="none" href="{{URL::action('Admin\AccountController@info', $order->account->account_id)}}"
                       target="_blank">
                        <div class="profile-userpic">
                            <img @if($order->account->avatar == '') src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                 @else src="{{$order->account->avatar}}" @endif class="img-responsive" alt=""
                                 style="max-width: 85px;">
                        </div>

                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                            <span class="full-name" style="font-size: 14px">
                                {{$order->account->first_name . ' ' . $order->account->last_name}}
                            </span>
                            <span class="request">
                                đã yêu cầu từ {{humanTiming(strtotime($order->request_time), 'vi')}}
                            </span>
                            </div>
                            <div class="profile-usertitle-job"></div>
                        </div>
                    </a>

                    <div class="table-scrollable table-scrollable-borderless">
                        <table class="table table-hover table-light order-detail">
                            <tbody>
                            <tr>
                                <td>Thời gian</td>
                                <td align="right" class="bold highlight">
                                    {{date('H:i d-m-Y', strtotime($order->request_time))}}
                                </td>
                            </tr>
                            @if($order->from_location)
                                <tr>
                                    <td>Từ</td>
                                    <td align="right">{{$order->from_location->name}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Đến</td>
                                <td align="right" class="bold highlight">
                                    {{$order->to_location->name}}
                                </td>
                            </tr>
                            @if($order->deliver_date != '')
                                <tr>
                                    <td>Ngày chuyển</td>
                                    <td align="right" class="bold highlight">
                                        {{date('d-m-Y', strtotime($order->deliver_date))}}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td>Tiền thưởng</td>
                                <td align="right" class="bold highlight">
                                    ${{$order->traveler_reward}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tiền hàng
                                </td>
                                <td align="right" class="bold highlight">
                                    ${{number_format(($order->price * $order->quantity), 2, '.', ',')}}
                                </td>
                            </tr>
                            <tr>
                                <td>Đơn giá</td>
                                <td align="right">${{$order->price}}</td>
                            </tr>
                            <tr>
                                <td>Số lượng</td>
                                <td align="right">{{$order->quantity}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-delicious font-green"></i>
                        <span class="caption-subject font-green bold uppercase">
                            Danh sách Offer
                        </span>
                    </div>
                </div>

                <div class="body">
                    @if(count($offers) > 0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="fit">STT</th>
                                            <th class="fit">#Offer</th>
                                            <th>Tài khoản</th>
                                            <th>Phí</th>
                                            <th>Mua từ</th>
                                            <th>Ngày đến</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($offers as $key => $offer)
                                            <tr>
                                                <td align="center">{{$key + 1}}</td>
                                                <td align="center">
                                                    <a role="button" class="btn btn-xs btn-primary"
                                                       data-target="#offer-info" data-toggle="modal"
                                                       href="{{URL::action('Admin\OfferController@info', $offer->offer_id)}}">
                                                        Xem <strong>#{{$offer->offer_id}}</strong>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{URL::action('Admin\AccountController@info', $offer->account->account_id)}}"
                                                       target="_blank" class="none">
                                                        <img @if($offer->account->avatar == '') src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                                             @else src="{{$offer->account->avatar}}"
                                                             @endif class="" alt="" style="max-width: 20px;">
                                                        {{$offer->account->first_name . ' ' . $offer->account->last_name}}

                                                        <span style="color: #000 !important;">
                                                            đã đề nghị từ
                                                            {{humanTiming(strtotime($offer->offer_time), 'vi')}}
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="bold">
                                                    ${{number_format(($offer->shipping_fee + $offer->tax + $offer->others_fee), 2, '.', ',')}}
                                                </td>
                                                <td>
                                                    {{$offer->from_location->name}}
                                                </td>
                                                <td align="right">{{date('d-m-Y', strtotime($offer->deliver_date))}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-12 text-center font-grey-silver bold font-14">
                                Chưa có Offer
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="offer-info" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-uppercase">
                        <i class="fa fa-circle-o-notch fa-spin"></i>
                        Đang xử lý dữ liệu
                    </h4>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/sliderengine/amazingslider.js')}}
    {{Html::script('assets/global/plugins/sliderengine/initslider-1.js')}}
@endsection