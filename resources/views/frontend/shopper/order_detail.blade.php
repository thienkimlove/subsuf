@extends('frontend.layout.template')
@section('style')

    {{Html::style('assets/global/plugins/owlcarousel/assets/owl.carousel.css')}}
    {{Html::style('assets/global/plugins/owlcarousel/assets/owl.theme.default.css')}}
    {{Html::style('assets/pages/css/profile.min.css')}}
    <style type="text/css">
        .owl-carousel .owl-item img {
            width: auto;
            display: inline;
        }

        .owl-carousel .owl-item {
            display: table;
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
    <div class="container margin-top-20 order-detail order-detail-block">
        @include("frontend.message")
        <div class="row">
            <div class="col-md-7">
                <div class="portlet light item-detail" style="">
                    <div class="portlet-body">
                        <div @if($order->order_images->count()>1)id="olwcarousel"@endif>
                            @foreach($order->order_images as $image)
                                <div style="height: 440px; display:table-cell; vertical-align:middle; text-align:center">
                                    <img src="{{URL::to($image->image)}}" style="max-width: 100%; max-height: 400px ">
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <hr>
                            <div class="col-lg-12">
                                <h2>{{$order->name}}</h2>

                                <p>{{$order->description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Session::has("userFrontend"))
                    @if($order->shopper_id==Session::get("userFrontend")["account_id"])
                        @if($order->order_status==2||$order->order_status==3)
                            <div class="portlet light profile-sidebar-portlet ">
                                <div class="portlet-body text-center uppercase">
                                    <div style="padding: 15px; padding-top: 0">
                                        @if($order->status==2)
                                            <a href="{{URL::action("Frontend\ShopperController@finishOrder",$order->order_id)}}"
                                               class="btn btn-block red btn-lg uppercase">{{trans("index.xacnhandanhanhang")}}</a>
                                        @else
                                            {{trans("index.dangchonguoimuahoxn")}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            <div class="col-md-5" id="order-detail-user">
                <div class="portlet light profile-sidebar-portlet ">
                    <div class="profile-userpic">
                        <a class="link-img"
                           href="{{URL::action("Frontend\UserController@userRateDetail",$order->account->account_id)}}">
                            <img src="{{URL::to($order->account->avatar)}}" class="img-responsive" alt=""
                                 style="width: 90px; height: 90px">
                        </a>
                    </div>
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">{{$order->account->first_name}} {{$order->account->last_name}}</div>
                        <div class="font-blue-oleo"> {{reltativeDate(date("d-m-Y H:i:s",strtotime($order->request_time)))}}</div>
                    </div>
                    <div class="usertitle-item">
                        <div class="font-red" style="float: right; font-size: 30px">
                            ${!! number_format($order->price*$order->quantity,2) !!}
                        </div>
                        <div style="margin-right:50px; color: #999; font-size: 15px; line-height: 40px">
                            @if($order->quantity>1)
                                {!! trans("index.giachonsanpham",["number"=>$order->quantity])!!}
                            @else
                                {!! trans("index.giacho1sanpham") !!}
                            @endif
                            <span class="font-red">
                         </span>
                        </div>

                    </div>
                    <div class="usertitle-item" style="margin-top: 0">
                        <div class="font-red" style="float: right; font-size: 30px">
                            ${{number_format($order->traveler_reward,2)}}
                        </div>
                        <div style="margin-right:50px; color: #999; font-size: 15px; line-height: 40px">
                            {{trans("index.tongtiencongnhanduoc")}}

                        </div>
                    </div>
                    <div class="order-delive" style="border-top: 1px solid #eee">
                        <span class="title">
                            <span class="title">
                                <span class="btn btn-sm red btn-circle"><i class="fa fa-map-marker"></i> </span>
                                {{trans("index.tu")}}
                            </span>
                            <span class="order-location">
                                {{($order->from_location) ? $order->from_location->name:trans("index.batkydau")}}
                            </span>
                        </span>
                    </div>
                    <div class="order-delive" style="border-bottom: 1px solid #eee">
                        <span class="title">
                            <span class="title">
                                <span class="btn btn-sm red btn-circle"><i class="fa fa-location-arrow"></i> </span>
                                {{trans("index.den")}}
                            </span>
                            <span class="order-location">
                                {{$order->to_location->name}}
                            </span>
                        </span>
                    </div>
                    @if($order->deliver_date)
                        <div class="order-delive" style="border-bottom: 1px solid #eee">
                        <span class="title">
                            <span class="title">
                                <span class="btn btn-sm red btn-circle"><i class="fa fa-calendar"></i> </span>
                                {{trans("index.ngaygiaohang")}}
                            </span>
                            <span class="order-location">
                                {{date("d-m-Y", strtotime($order->deliver_date))}}
                            </span>
                        </span>
                        </div>
                    @endif
                    @if($order->link)
                        <div class="order-delive" style="border-bottom: 1px solid #eee">
                            <span class="title">
                                <span class="title">
                                    <span class="btn btn-sm red btn-circle"><i class="fa fa-globe"></i> </span>
                                    {{trans("index.muatu")}}
                                </span>
                                <span class="order-location">
                                    <a href="{{trim($order->link)}}"
                                       target="_blank">{{parse_url(trim($order->link), PHP_URL_HOST)}}</a>
                                </span>
                            </span>
                        </div>
                    @endif

                    <div style="padding: 15px">
                        @if(Session::has("userFrontend"))
                            @if(!($order->shopper_id==Session::get("userFrontend")["account_id"]))
                                @if($isOffer)
                                @else
                                    <a href="{{URL::action("Frontend\TravelerController@offer",$order->order_id)}}"
                                       class="btn btn-block red btn-lg">{{trans("index.nhanmuaho")}}</a>
                                @endif
                            @else
                                @if($order->order_status==1||$order->order_status==-1)
                                    @if($order->order_status==1)
                                        <a href="{{URL::action("Frontend\ShopperController@editOrder",$order->order_id)}}"
                                           {{--onclick="return confirm('{{trans("index.edit_order_confirm")}}');"--}}
                                           role="button" class="btn btn-block green btn-lg">
                                            {{trans("index.suayeucau")}}
                                        </a>
                                        <br>
                                        <a href="{{URL::action("Frontend\ShopperController@deactiveOrder",$order->order_id)}}"
                                           onclick="return confirm('{{trans("index.edit_order_confirm")}}');"
                                           role="button" class="btn btn-block red btn-lg">
                                            {{trans("index.huyyeucau")}}
                                        </a>
                                    @else
                                        <a href="{{URL::action("Frontend\ShopperController@activeOrder",$order->order_id)}}"
                                           class="btn btn-block blue btn-lg">{{trans("index.dangyeucau")}}</a>
                                    @endif
                                @endif
                            @endif
                        @else
                            <a href="{{URL::action("Frontend\TravelerController@offer",$order->order_id)}}"
                               class="btn btn-block red btn-lg">{{trans("index.nhanmuaho")}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="portlet light profile-sidebar-portlet ">
                    <div class="portlet-title text-center uppercase">
                        {{trans("index.denghidangcho")}}
                    </div>
                    <div class="portlet-body">
                        @if(!($offer->count()))
                            <p class="text-center"><i>{{trans("index.chuacodenghinao")}}</i></p>
                            <br>
                        @endif
                        @if($order->order_status>0)
                            @foreach($offer as $item)
                                <div style="padding: 10px 15px; margin-bottom: 20px; clear: both; border-bottom: 5px solid #eff3f8 ">
                                    <a class="link-img"
                                       href="{{URL::action("Frontend\UserController@userRateDetail",$item->account->account_id)}}">

                                        <img class="img-circle" src="{{URL::to($item->account->avatar)}}"
                                             style="width: 50px; height: 50px; float: left;">
                                    </a>
                                    <div style="margin-left: 60px; height: 80px;">
                                    <span style="float: right; text-align: right; font-size: 18px; font-weight: 500; width:50%; float: right"
                                          class="font-red">
                                        ${{$item->shipping_fee+$item->tax+$item->others_fee}}
                                        <small class="font-dark">
                                            <i class="fa fa-info-circle font-blue popovers"
                                               style="cursor: pointer"
                                               data-trigger="hover"
                                               data-html="true"
                                               data-container="body"
                                               data-placement="top"
                                               data-original-title="{{trans("index.tongtiencongnhanduocdabaogom")}}:"
                                               data-content='
                                                                    @if($item->shipping_fee)
                                                       <span class="font-red"> ${{$item->shipping_fee}}</span> {{trans("index.phivanchuyennoidia")}}.
                                                                    @endif
                                               @if($item->tax)
                                                       <span class="font-red"> ${{$item->tax}}</span> {{trans("index.thue")}}
                                               @endif
                                                       </span>'
                                            ></i>
                                        </small>
                                    </span>
                                        <a href=""
                                           class="bold"
                                           style="line-height: 27px">{{$item->account->first_name}} {{$item->account->last_name}}</a>
                                        <br>
                                        <small> {{trans("index.dadenghi")}}
                                            {{reltativeDate(date("d-m-Y H:i:s",strtotime($item->offer_time)))}}</small>
                                        <br>


                                        <p class="text-center">
                                        <span style="font-size: 12px; color: #999;" class="">
                                          <br>
                                            {{--<span class="font-red"> ${{$item->others_fee}}</span> tiền công,--}}
                                        </span>
                                        </p>
                                    </div>
                                    @if(Session::has("userFrontend"))
                                        @if($order->shopper_id==Session::get("userFrontend")["account_id"])
                                            <div class="order-delive" style="border-top: 1px solid #eee">
                                            <span class="title">
                                                    <span class="title">
                                                        <span class="btn btn-sm red btn-circle"><i
                                                                    class="fa fa-envelope"></i> </span> {{trans("index.lienlac")}}
                                                        </span>
                                                <span class="order-location">
                                                           {{$item->account->email}}
                                                </span>
                                            </span>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="order-delive" style="border-top: 1px solid #eee">
                                    <span class="title">
                                            <span class="title">
                                                <span class="btn btn-sm red btn-circle"><i class="fa fa-map-marker"></i> </span> {{trans("index.tu")}}
                                                </span>
                                        <span class="order-location">{{($item->from_location)?$item->from_location->name:trans("index.batkydau")}}</span>
                                    </span>
                                    </div>
                                    <div class="order-delive" style="border-top: 1px solid #eee">
                                    <span class="title">
                                            <span class="title">
                                                <span class="btn btn-sm red btn-circle"><i
                                                            class="fa fa-location-arrow"></i> </span> {{trans("index.den")}}
                                                </span>
                                        <span class="order-location">{{($order->to_location->name)?$order->to_location->name:""}}</span>
                                    </span>
                                    </div>
                                    <div class="order-delive" style="border-top: 1px solid #eee">
                                    <span class="title">
                                        <span class="title">
                                            <span class="btn btn-sm red btn-circle"><i
                                                        class="fa fa-calendar"></i> </span> {{trans("index.ngaygiaohang")}}
                                            </span>
                                        <span class="order-location">{{date("d-m-Y",strtotime($item->deliver_date))}}</span>
                                    </span>
                                    </div>
                                    @if($item->deliver_details)
                                        <div class="order-delive" style="border-top: 1px solid #eee">
                                    <span class="title">
                                        <span class="title">
                                            <span class="btn btn-sm red btn-circle"><i
                                                        class="fa fa-sticky-note-o"></i> </span> {{trans("index.note")}}
                                            </span>
                                        <span class="order-location">{!! $item->deliver_details !!}</span>
                                    </span>
                                        </div>
                                    @endif

                                    <div>
                                        @if(Session::has("userFrontend"))
                                            @if($order->shopper_id==Session::get("userFrontend")["account_id"])
                                                <a href="{{URL::action("Frontend\ShopperController@acceptOffer",$item->offer_id)}}"
                                                   class="btn btn-block red btn-lg">{{trans("index.chapnhandenghi")}}</a>
                                            @endif
                                            @if($item->traveler_id==Session::get("userFrontend")["account_id"])
                                                <a href="{{URL::action("Frontend\TravelerController@cancelOffer",$item->offer_id)}}"
                                                   class="btn btn-block red btn-lg">
                                                    <i class="fa fa-times"></i>
                                                    {{trans("index.huydenghi")}}
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            {{--<div class="clearfix"></div>--}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/owlcarousel/owl.carousel.min.js')}}
    <script type="text/javascript">
        $("#olwcarousel").owlCarousel({
            loop: true,
            nav: true,
            margin: 30,
            items: 1
        })
    </script>
    <style>
        .owl-prev {
            position: absolute;
            bottom: 50%;
            left: -20px;
            background: rgba(231, 30, 41, 0.72) !important;
        }

        .owl-next {
            position: absolute;
            bottom: 50%;
            right: -20px;
            background: rgba(231, 30, 41, 0.72) !important;
        }

        .owl-theme .owl-dots .owl-dot span {
            border-radius: 5px !important;
        }

        .owl-theme .owl-dots .owl-dot.active span {
            background: rgba(231, 30, 41, 0.72) !important;
        }
    </style>
@endsection