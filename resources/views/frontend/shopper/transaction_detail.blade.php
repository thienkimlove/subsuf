@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/pages/css/search.min.css')}}
    <style type="text/css">
        #orderDetail h2 {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #69717e;
        }

        .content-right {
            font-size: 14px;
            float: right;
            text-transform: none;
        }

        #orderDetail .col-xs-12 h2 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
    </style>
@endsection
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

    <div class="container white">
        <div class="row margin-top-40">
            <div class="col-lg-8 col-lg-offset-2">
                <div class=" bg-grey-steel">
                    <div class="transaction-user" style="">
                        <div class="transaction-user-info">
                            <a href="{{URL::action("Frontend\UserController@userRateDetail",$offer->traveler_id)}}">
                                <img class="img-circle" src="{{URL::to($offer->account->avatar)}}">
                                <p class="user-info-name">
                                    {{$offer->account->first_name}} {{$offer->account->last_name}}
                                </p>
                            </a>
                            <p class="transaction-locaction">{{$offer->from_location["name"]}}</p>
                        </div>
                        <div style="width: 60px; float:left;font-size: 11px; color: #666" class="text-center">
                            <br>
                            <i class="fa fa-2x fa-plane"></i>
                            <br>
                            {{date("d-m-Y",strtotime($offer->deliver_date))}}
                        </div>
                        <div style="width: 120px; float:left;" class="transaction-user-info">
                            <a href="{{URL::action("Frontend\UserController@userRateDetail",$order->shopper_id)}}">
                                <img class="img-circle" src="{{URL::to($order->account->avatar)}}">
                                <p class="user-info-name">
                                    {{$order->account->first_name}} {{$order->account->last_name}}
                                </p>
                            </a>
                            <p class="transaction-locaction">{{$order->to_location["name"]}}</p>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="portlet light">
                    <div class="portlet-body form">
                        <div class="row">
                            <div class="col-lg-12 margin-top-10">

                                <div class="form-group" id="orderDetail">
                                    <div class="col-xs-12">
                                        <h2 class="invoice-title uppercase">
                                            <span class="content-right font-red">
                                            <p>
                                                ${{number_format(($order->price * $order->quantity), 2, '.', ',')}}
                                            </p>
                                            </span>
                                            <div style="margin-right: 100px">
                                                {{$order->name}}
                                            </div>
                                        </h2>
                                    </div>
                                    <div class="col-xs-12">
                                        <h2 class="invoice-title uppercase">{{trans("index.traveler_reward")}}
                                            <span class="content-right font-red">
                                                <p>
                                                    <?php $reward = $offer->shipping_fee + $offer->tax + $offer->others_fee; ?>
                                                    ${{number_format(($reward), 2, '.', ',')}}
                                                </p>
                                            </span>
                                        </h2>
                                    </div>
                                    @if($isShopper)
                                        <div class="col-xs-12">
                                            <h2 class="invoice-title uppercase">{{trans("index.phidichvu")}}
                                                <span class="content-right font-red">
                                                <p>
                                                    ${{$transaction->service_fee}}
                                                </p>
                                            </span>
                                            </h2>
                                        </div>
                                        <div class="col-xs-12">
                                            <h2 class="invoice-title uppercase">{{trans("index.giamgia")}}
                                                <span class="content-right font-red">
                                                <p>
                                                     -$@if($transaction->coupon){{$transaction->coupon->money}} @else
                                                        0 @endif
                                                </p>
                                            </span>
                                            </h2>
                                        </div>
                                        <div class="col-lg-12" style="border: none">
                                            <h2 class="invoice-title uppercase">{{trans("index.tongtien")}}
                                                <span class="content-right font-red text-right">
                                                <b style="font-size: 20px">
                                                    ${{$transaction->total}}

                                                    <br>
                                                    <p><small class="font-red">{{number_format($transaction->total*$exchange)}}
                                                    VND</small></p>
                                                </b>
                                            </span>
                                            </h2>
                                        </div>

                                    @endif
                                    @if($isTraveler)
                                        <div class="col-lg-12" style="border: none">
                                            <h2 class="invoice-title uppercase">{{trans("index.tongtien")}}
                                                <span class="content-right font-red text-right">
                                                <b style="font-size: 20px">
                                                    ${{number_format(($order->price * $order->quantity+$reward), 2, '.', ',')}}
                                                    <small>
                                                            <a class="font-blue popovers" data-container="body"
                                                               data-html="true"
                                                               data-trigger="hover"
                                                               data-placement="top"
                                                               data-content="{{trans("index.theotigiavietcombank")}}"
                                                               aria-describedby="popover232814">
                                                                <i class="fa fa-question-circle fa-blue"></i>
                                                            </a>
                                                        </small>
                                                    <br>
                                                    {{--<p><small class="font-red">{{number_format(($order->price * $order->quantity+$reward)*$exchange)}}--}}
                                                    {{--VND</small></p>--}}
                                                </b>
                                            </span>
                                            </h2>
                                        </div>
                                        <div class="col-lg-12" style="border: none">
                                            @if($offer->offer_status==2)
                                                <div class="alert alert-warning text-center">{{trans("index.dangchonguoidathangxn")}}</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="form-actions text-center">
                                        @include("frontend.message")
                                        @if($offer->offer_status==3&&$order->order_status==3)
                                            <a href="{{URL::action("Frontend\UserController@userRate",$transaction->transaction_id)}}"
                                               style="width: 300px" class="btn btn-outline blue btn-lg">
                                                <i class="fa fa-star"></i> {{trans("index.writeareview")}}
                                            </a>
                                        @endif
                                        @if($isShopper)
                                            @if($order->order_status==2||$order->order_status==3)
                                                <div class="portlet light profile-sidebar-portlet ">
                                                    {!! Form::open(['action' => ['Frontend\ShopperController@finishOrder',$order->order_id], 'method' => 'GET', "data-toggle"=>"validator"]) !!}
                                                    <div class="portlet-body text-center uppercase">
                                                        @if($order->order_status==2)
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <i class="lowercase">{{trans("index.xacnhandanhanhang_detail")}}</i>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            {{--<div style="padding: 15px 0;">--}}
                                                            {{--<div id="captchaGG"--}}
                                                            {{--style="margin:auto; width: 304px;"--}}
                                                            {{--class="form-group g-recaptcha"--}}
                                                            {{--data-sitekey="{{ config('app.RE_CAP_SITE') }}"></div>--}}
                                                            {{--</div>--}}

                                                            <div class="form-group text-center">
                                                                {!! captcha_img() !!}
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label visible-ie8 visible-ie9"> {{trans("index.captcha")}}</label>
                                                                <input class="input-lg  form-control form-control-solid placeholder-no-fix"
                                                                       type="text"
                                                                       autocomplete="off"
                                                                       placeholder="{{trans("index.captcha")}}"
                                                                       name="captcha" required/>
                                                            </div>
                                                        @endif
                                                        <div style="padding: 15px; padding-top: 0">
                                                            @if($order->order_status==2)
                                                                <button type="submit"
                                                                        class="btn btn-block red btn-lg"
                                                                        style="font-size: 14px">
                                                                    {{trans("index.xacnhandanhanhang")}}
                                                                </button>
                                                                {{--<br>--}}
                                                                {{--<a onclick="return confirm('xác nhận hủy giao dịch!')"--}}
                                                                {{--href="{{URL::action("Frontend\ShopperController@deleteTransaction",$order->order_id)}}">--}}
                                                                {{--{{trans("index.huygiaodich")}}--}}
                                                                {{--</a>--}}
                                                            @elseif($offer->offer_status!=3)
                                                                <div class="alert alert-warning">
                                                                    {{trans("index.dangchonguoimuahoxn")}}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    {{Form::close()}}
                                                </div>
                                            @endif
                                        @endif
                                        @if($isTraveler)
                                            @if($offer->offer_status==2||$order->offer_status==3)
                                                <div class="portlet light profile-sidebar-portlet ">
                                                    <div class="portlet-body text-center uppercase">
                                                        @if($offer->offer_status==2)
                                                            {{--<a href="{{URL::action("Frontend\ShopperController@finishOrder",$offer->order_id)}}"--}}
                                                            {{--class="btn btn-block red btn-lg">XÁC NHẬN ĐÃ CHUYỂN HÀNG</a>--}}
                                                            {{--<br>--}}
                                                            <a class="btn btn-default btn-block"
                                                               onclick="return confirm('{{trans("index.cancel_offer")}}')"
                                                               href="{{URL::action("Frontend\ShopperController@deleteTransaction",$order->order_id)}}">
                                                                {{trans("index.huygiaodich")}}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/pages/scripts/convert-image-to-base64.js')}}
    {{Html::script("https://www.google.com/recaptcha/api.js")}}


@endsection