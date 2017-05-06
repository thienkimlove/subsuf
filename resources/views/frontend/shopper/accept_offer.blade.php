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
                <div class="portlet light">
                    <div class="portlet-body form">

                        <hr>

                        <div class="row">
                            {!! Form::open(['action' => ['Frontend\PaymentController@payment_order',$offer->offer_id], 'method' => 'POST','id'=>'addPlanDetail', 'files' => true,"data-toggle"=>"validator"]) !!}
                            <div class="col-lg-12 margin-top-10">
                                <div class="clearfix margin-bottom-10"></div>
                                <div class="form-group">
                                    <h4>{{trans("index.magiamgia")}}</h4>
                                    <a class="btn btn-block red btn-outline btn-lg" id="addCoupon"
                                       data-target="#couponModal"
                                       data-toggle="modal"><i
                                                class="fa fa-plus"></i> {{trans("index.themmagiamgia")}}</a>
                                    <div id="couponAdded" style="display: none">
                                        <span class="couponValue font-red">
                                            $0
                                        </span>
                                        <div class="actions">
                                            <a class="btn  red btn-outline btn-lg" data-target="#couponModal"
                                               data-toggle="modal"> {{trans("index.suacoupon")}}</a>
                                        </div>
                                    </div>

                                    <div id="couponModal" class="modal fade" tabindex="-1" data-backdrop="static"
                                         data-keyboard="false">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-hidden="true"></button>
                                                    <h4 class="modal-title">{{trans("index.themcoupon")}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-warning" style="display: none">
                                                        {{trans("index.macouponkhongdung")}}
                                                    </div>

                                                    <div class="input-group input-group-lg">
                                                        <input class="form-control" id="couponCodeNew" type="text"
                                                               name="text"
                                                               placeholder="Add Coupon">
                                                        <span class="input-group-btn">
                                                                <button id="genpassword" onclick="addNewCoupon()"
                                                                        class="btn red"
                                                                        type="button">
                                                                     {{trans("index.themcoupon")}}</button>
                                                            </span>
                                                    </div>
                                                    <hr>
                                                    @if($coupon)

                                                        <h4>{{trans("index.chonmacoupon")}}</h4>
                                                        @foreach($coupon as $item)
                                                            <p>
                                                                <button type="button" data-dismiss="modal"
                                                                        class="btn red btn-block btn-lg text-left"
                                                                        onclick="addCoupon({{(float)$item->amount_be_coupon}},{{$item->coupon_id}})">
                                                                    <span style="float: left">
                                                                       ${{$item->amount_be_coupon}}
                                                                    </span>
                                                                    <span style="float: right">{{$item->coupon_code}}</span>
                                                                </button>
                                                            </p>
                                                            <p class="text-center">
                                                                <button type="button" data-dismiss="modal"
                                                                        id="resetCoupon" style="display: none"
                                                                        class="btn default btn-lg"
                                                                        onclick="removeCoupon()">
                                                                    {{trans("index.xoacoupon")}}
                                                                </button>
                                                            </p>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group" id="orderDetail">
                                    <div class="col-xs-12">
                                        <h2 class="uppercase"> {{trans("index.tiencong")}}</h2>
                                        <a class="link-img"
                                           href="{{URL::action("Frontend\UserController@userRateDetail",$offer->account->account_id)}}">

                                            <img class="img-circle" src="{{URL::to($offer->account->avatar)}}"
                                                 style="width: 50px; height: 50px; float: left;">
                                        </a>
                                        <div style="margin-left: 60px; height: 60px;">
                                            <span style="float: right;  font-size: 22px; margin-top: 10px"
                                                  class="font-red">
                                                ${{$offer->shipping_fee+$offer->tax+$offer->others_fee}}
                                            </span>

                                            <a href="" class="bold">
                                                {{$offer->account->first_name}} {{$offer->account->last_name}}
                                            </a>
                                            <p style="margin-top: 10px;" class="font-blue-oleo">
                                                <i class="fa fa-calendar font-grey-salt"></i>
                                                {{trans("index.chuyendenvaongay")}}  {{date("d-m-Y",strtotime($offer->deliver_date))}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <h2 class="invoice-title uppercase">
                                            <span class="content-right font-red">
                                                <p>
                                                    ${{number_format(($order->price * $order->quantity), 2, '.', ',')}}
                                                </p>
                                            </span>
                                            <div style="margin-right:100px">
                                                {{$order->name}}
                                            </div>

                                        </h2>
                                    </div>
                                    <div class="col-xs-12">
                                        <h2 class="invoice-title uppercase">
                                            {{trans("index.phidichvu")}}
                                            {{--<a class="popovers" data-container="body"--}}
                                            {{--data-content="{!! trans("index.detailphidichvu") !!}"--}}
                                            {{--data-html="true"--}}
                                            {{--data-trigger="hover"--}}
                                            {{--data-original-title="{{trans("index.cachtinhphidichvu")}}"--}}
                                            {{--aria-describedby="popover232814">--}}
                                            {{--<i class="fa fa-question-circle font-blue"></i> </a>--}}
                                            <span class="content-right font-red">
                                                <p>
                                                    ${{$fee}}
                                                </p>
                                            </span>
                                        </h2>
                                    </div>
                                    <div class="col-xs-12 discount-col" style="display: none">
                                        <h2 class="invoice-title uppercase">
                                            <span class="content-right font-red">
                                                <p>

                                                </p>
                                            </span>
                                            <div style="margin-right:100px">
                                                {{trans("index.giamgia")}}
                                            </div>

                                        </h2>
                                    </div>

                                    <div class="col-lg-12" style="border: none">
                                        <h2 class="invoice-title uppercase">{{trans("index.tongtien")}}
                                            <span class="content-right font-red text-right">
                                                <b style="font-size: 20px">
                                                    $<span id="totalMoney">{{$total+$fee}}</span>
                                                    <small><a class="font-blue popovers" data-container="body"
                                                              data-original-title="$1 = {{$exchange}} VND"
                                                              data-html="true"
                                                              data-trigger="hover"
                                                              data-placement="top"
                                                              data-content="{{trans("index.tigiaquydoitheopaypal")}}"
                                                              aria-describedby="popover232814">
                                                <i class="fa fa-question-circle fa-blue"></i></a>
                                                        </small>
                                                </b>
                                                <br>
                                                <br>
                                                <b style="font-size: 16px">
                                                     <span id="totalMoneyEx">{{number_format(($total+$fee)*$exchange)}}</span> VND

                                                </b>
                                            </span>
                                        </h2>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="alert alert-info">
                                    {{trans("index.subsufgiutienhoban")}}
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-actions text-center">
                                        <button type="submit" class="btn red btn-lg">{{trans("index.thanhtoan")}} </i>
                                        </button>
                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}"
                                           class="btn defaults btn-lg">{{trans("index.quaylai")}}</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{Form::close()}}
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

    <script type="text/javascript">

        totalMoney = parseFloat({{round($total+$fee,2)}});
        exchange = parseFloat({{$exchange}});
        function addCoupon(counpon, id) {
            $("#couponAdded").show();
            $(".discount-col").show();
            $("#addCoupon").hide();

            $("#couponAdded .couponValue").html(
                    "$" + counpon +
                    '<input type="hidden" name="coupon" value="' + id + '">'
            );
            $(".discount-col p").html("-$" + counpon);
            var total1 = addCommas(parseFloat(totalMoney - counpon).toFixed(2));
            var total2 = addCommas(parseInt((totalMoney - counpon) * exchange));
            $("#totalMoney").html(total1);
            $("#totalMoneyEx").html(total2);
            $("#resetCoupon").show();
            $("#couponModal .alert").hide();
        }
        function addNewCoupon() {
            $.ajax(
                    {
                        url: "{{URL::action("Frontend\ShopperController@addCouponCode")}}",
                        target: "GET",
                        data: {
                            coupon: $("#couponCodeNew").val(),
                            total: totalMoney,
                        },
                    }
            ).done(function (msg) {
                if (msg.status != 1) {
                    $("#couponModal .alert").html(msg.message);
                    $("#couponModal .alert").show();
                } else {
                    addCoupon(msg.data.amount_be_coupon, msg.data.coupon_id);
                    $("#couponModal").modal('hide');
                }
            });
        }
        function removeCoupon() {
            $("#addCoupon").show();
            $(".discount-col").hide();
            $("#totalMoney").html(addCommas(totalMoney));
            $("#totalMoneyEx").html(addCommas(parseInt(totalMoney * exchange)));
            $("#couponAdded").hide();
            $("#resetCoupon").hide();
            $("#couponAdded .couponValue").html("");
        }
        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    </script>
@endsection