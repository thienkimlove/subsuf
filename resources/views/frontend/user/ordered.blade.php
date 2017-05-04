@extends('frontend.layout.template')
@section('style')
    <link media="all" type="text/css" rel="stylesheet" href="/assets/pages/css/profile.min.css">
    <style>
        .user-order-list .portlet-body {
            max-height: 610px;
            overflow: hidden;

        }
    </style>
@endsection
@section('breadcrumb')

@endsection

@section('content')

    <div class="container margin-top-40">
        <div class="col-md-12">
            @include("frontend.message")
            <div class="profile-sidebar">
                @include("frontend.user.profile_menu")
            </div>

            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">

                        <div class="portlet light user-order-list">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{trans("index.donhangdangchonhanhang")}}</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"
                                       data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php $count = 0; ?>
                                @foreach($orderList as $order)
                                    @if($order->order_status==2)
                                        <?php $count++; ?>
                                        <div class=" order-full">
                                            <div class="order-thumbnail">
                                                <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">
                                                    <img src="@if(count($order->order_images)) {{URL::to($order->order_images[0]->image)}} @endif"/>
                                                </a>

                                            </div>
                                            <div class="order-title">
                                                <div class="order-user">
                                                    <a href="#">
                                                        <img alt="" class="img-circle"
                                                             src="{{URL::to($order->account["avatar"])}}">
                                                        <b>{{$order->account["first_name"]}} {{$order->account["last_name"]}}</b>
                                                    </a>


                                                    <span class="order-time">{{date("d-m-Y",strtotime($order->request_time))}}</span>
                                                </div>
                                                <div class="order-content">
                                                    <h3>
                                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">{{$order->name}}</a>
                                                    </h3>
                                                    <div class="order-delive" style="border-bottom: 1px solid #eee">
                                                        <span class="title">
                                                            <span class="title">
                                                                <span class="btn btn-sm red btn-circle"><i
                                                                            class="fa fa-map-marker"></i>
                                                                </span> {{trans("index.den")}}
                                                            </span>
                                                            </span>
                                                        <span class="order-location">{{$order->to_location->name}}</span>
                                                    </div>
                                                    <div class="order-delive">
                                                        <span class="title"><span class="btn btn-sm red btn-circle"><i
                                                                        class="fa fa-location-arrow"></i></span> {{trans("index.tu")}}</span>
                                                        <span class="order-location">@if($order->from_location) {{$order->from_location->name}} @else {{trans("index.batkydau")}} @endif</span>
                                                    </div>
                                                </div>
                                                <div class="order-off">
                                                    Offered {{$order->offers->count()}}

                                                    <div class="action">
                                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}"> {{trans("index.chitiet")}}
                                                            <i class="fa fa-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                @endforeach
                            </div>
                            @if($count>2)
                                <button class="btn btn-show-all default btn-block" data-show="false">
                                    <i class="fa fa-chevron-down"></i></button>
                            @endif
                        </div>
                        {{--ĐƠn hàng đang chờ offer--}}

                        <div class="portlet light user-order-list">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{trans("index.donhangdangcho")}}</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"
                                       data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php $count = 0; ?>
                                @foreach($orderList as $order)
                                    @if($order->order_status==1)
                                        <?php $count++; ?>
                                        <div class=" order-full">
                                            <div class="order-thumbnail">
                                                <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">
                                                    <img src="@if(count($order->order_images)) {{URL::to($order->order_images[0]->image)}} @endif"/>
                                                </a>

                                            </div>
                                            <div class="order-title">
                                                <div class="order-user">
                                                    <a href="#">
                                                        <img alt="" class="img-circle"
                                                             src="{{URL::to($order->account["avatar"])}}">
                                                        <b>{{$order->account["first_name"]}} {{$order->account["last_name"]}}</b>
                                                    </a>
                                                    <span class="order-time">{{date("d-m-Y",strtotime($order->request_time))}}</span>
                                                </div>
                                                <div class="order-content">
                                                    <h3>
                                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">{{$order->name}}</a>
                                                    </h3>
                                                    <div class="order-delive" style="border-bottom: 1px solid #eee">
                                                    <span class="title">
                                                        <span class="title">
                                                            <span class="btn btn-sm red btn-circle">
                                                                <i class="fa fa-map-marker"></i>
                                                            </span>
                                                            {{trans("index.den")}}
                                                        </span>
                                                    </span>
                                                        <span class="order-location">{{$order->to_location->name}}</span>
                                                    </div>
                                                    <div class="order-delive">
                                                        <span class="title"><span class="btn btn-sm red btn-circle"><i
                                                                        class="fa fa-location-arrow"></i></span> {{trans("index.tu")}}</span>
                                                        <span class="order-location">@if($order->from_location) {{$order->from_location->name}} @else {{trans("index.batkydau")}} @endif</span>
                                                    </div>
                                                </div>
                                                <div class="order-off">
                                                    Offered {{$order->offers->count()}}

                                                    <div class="action">
                                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}"> {{trans("index.chitiet")}}
                                                            <i class="fa fa-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                @endforeach

                            </div>
                            @if($count>2)
                                <button class="btn btn-show-all default btn-block" data-show="false">
                                    <i class="fa fa-chevron-down"></i></button>
                            @endif
                        </div>
                        {{--ĐƠn hàng đang không hoạt động--}}
                        <div class="portlet light user-order-list">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{trans("index.donhangkhonghoatdong")}}</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"
                                       data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php $count = 0; ?>
                                @foreach($orderList as $order)
                                    @if($order->order_status==-1)
                                        <?php $count++; ?>

                                        <div class=" order-full">
                                            <div class="order-thumbnail">
                                                <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">
                                                    <img src="@if(count($order->order_images)) {{URL::to($order->order_images[0]->image)}} @endif"/>
                                                </a>

                                            </div>
                                            <div class="order-title">
                                                <div class="order-user">
                                                    <a href="#">
                                                        <img alt="" class="img-circle"
                                                             src="{{URL::to($order->account["avatar"])}}">
                                                        <b>{{$order->account["first_name"]}} {{$order->account["last_name"]}}</b>
                                                    </a>


                                                    <span class="order-time">{{date("d-m-Y",strtotime($order->request_time))}}</span>
                                                </div>
                                                <div class="order-content">
                                                    <h3>
                                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">{{$order->name}}</a>
                                                    </h3>
                                                    <div class="order-delive" style="border-bottom: 1px solid #eee">
                                                    <span class="title">
                                                        <span class="title">
                                                            <span class="btn btn-sm red btn-circle"><i
                                                                        class="fa fa-map-marker"></i> </span> {{trans("index.den")}}
                                                            </span>
                                                            </span>
                                                        <span class="order-location">{{$order->to_location->name}}</span>
                                                    </div>
                                                    <div class="order-delive">
                                                        <span class="title"><span class="btn btn-sm red btn-circle"><i
                                                                        class="fa fa-location-arrow"></i></span> {{trans("index.tu")}}</span>
                                                        <span class="order-location">@if($order->from_location) {{$order->from_location->name}} @else {{trans("index.batkydau")}} @endif</span>
                                                    </div>
                                                </div>
                                                <div class="order-off">
                                                    Offered {{$order->offers->count()}}

                                                    <div class="action">
                                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}"> {{trans("index.chitiet")}}
                                                            <i class="fa fa-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                @endforeach
                            </div>
                            @if($count>2)
                                <button class="btn btn-show-all default btn-block" data-show="false">
                                    <i class="fa fa-chevron-down"></i></button>
                            @endif
                        </div>
                        {{--ĐƠn hàng đã hoàn thành--}}

                        <div class="portlet light user-order-list">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">{{trans("index.donhangdahoanthanh")}}</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"
                                       data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php $count = 0; ?>
                                @foreach($orderList as $order)
                                    @if($order->order_status==3)
                                        <?php $count++; ?>
                                        <div class=" order-full">
                                            <div class="order-thumbnail">
                                                <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">
                                                    <img src="@if(count($order->order_images)) {{URL::to($order->order_images[0]->image)}} @endif"/>
                                                </a>

                                            </div>
                                            <div class="order-title">
                                                <div class="order-user">
                                                    <a href="#">
                                                        <img alt="" class="img-circle"
                                                             src="{{URL::to($order->account["avatar"])}}">
                                                        <b>{{$order->account["first_name"]}} {{$order->account["last_name"]}}</b>
                                                    </a>


                                                    <span class="order-time">{{date("d-m-Y",strtotime($order->request_time))}}</span>
                                                </div>
                                                <div class="order-content">
                                                    <h3>
                                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">{{$order->name}}</a>
                                                    </h3>
                                                    <div class="order-delive" style="border-bottom: 1px solid #eee">
                                                        <span class="title">
                                                            <span class="title">
                                                                <span class="btn btn-sm red btn-circle"><i
                                                                            class="fa fa-map-marker"></i> </span> {{trans("index.den")}}
                                                                </span>
                                                            </span>
                                                        <span class="order-location">{{$order->to_location->name}}</span>
                                                    </div>
                                                    <div class="order-delive">
                                                        <span class="title"><span class="btn btn-sm red btn-circle"><i
                                                                        class="fa fa-location-arrow"></i></span> {{trans("index.tu")}}</span>
                                                        <span class="order-location">@if($order->from_location) {{$order->from_location->name}} @else {{trans("index.batkydau")}} @endif</span>
                                                    </div>
                                                </div>
                                                <div class="order-off">
                                                    Offered {{$order->offers->count()}}

                                                    <div class="action">
                                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}"> {{trans("index.chitiet")}}
                                                            <i class="fa fa-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                @endforeach
                            </div>
                            @if($count>2)
                                <button class="btn btn-show-all default btn-block" data-show="false">
                                    <i class="fa fa-chevron-down"></i></button>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(".btn-show-all").click(function () {
            var $this = $(this);
            var show = $(this).data("show");
            if (show) { // đang hiện hết
                $this.data("show", false); // thu lại
                $(this).parents(".user-order-list").find(".portlet-body").css("max-height", "600px");
                $this.find("i").removeClass("fa-chevron-up");
                $this.find("i").addClass("fa-chevron-down");
                $(document).scrollTo($(this).parent());
            } else { // đang thu
                $this.data("show", true); // hiện hết
                $(this).parents(".user-order-list").find(".portlet-body").css("max-height", "10000px");
                $this.find("i").removeClass("fa-chevron-down");
                $this.find("i").addClass("fa-chevron-up");
            }
        })
    </script>
@endsection