@extends('v2.template')

@section('content')


    <div class="wrap_container">

        <div class="wrap_ChiTietDonHang wrap_NhanMuaHoChiTiet">
            <div class="container">
                @include("frontend.message")
                <div class="row">
                    <div class="col-xs-12 col-sm-7 col-md-7">
                        <div class="wrap_product">
                            <div class="slider_image">
                                <div class="owl-carousel owl-theme owl-slider_image_chitietdonhang">
                                    @foreach($order->order_images as $image)
                                        <div class="item">
                                            <a href="#">
                                                <img src="{{URL::to($image->image)}}" alt="">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="info_product">
                                <h3 class="name_product">
                                    <a href="#">{{$order->name}}</a>
                                </h3>
                                <p>
                                    {{$order->description}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-4 col-md-offset-1">
                        <div class="wrap_info_donhang">
                            <div class="user_item">
                                <a class="img_user"
                                   href="{{URL::action("Frontend\UserController@userRateDetail",$order->account->account_id)}}">
                                    <img src="{{URL::to($order->account->avatar)}}" alt="">
                                </a>
                                <div class="name_datetime">
                                    <a class="name_user"
                                       href="{{URL::action("Frontend\UserController@userRateDetail",$order->account->account_id)}}">{{$order->account->first_name}} {{$order->account->last_name}}</a>
                                    <span class="datetime">
                                        {{reltativeDate(date("d-m-Y H:i:s",strtotime($order->request_time)))}}
                                    </span>
                                </div>
                            </div>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>{{trans("index.madonhang")}}:</td>
                                    <td><span>{{ $order->code }}</span></td>
                                </tr>
                                <tr>
                                    @if($order->quantity>1)
                                        <td> {!! trans("index.giachonsanpham",["number"=>$order->quantity])!!}</td>
                                    @else
                                        <td> {!! trans("index.giacho1sanpham") !!}</td>
                                    @endif
                                    <td><span>${!! number_format($order->price*$order->quantity,2) !!}</span></td>
                                </tr>
                                <tr>
                                    <td>{{trans("index.tongtiencongnhanduoc")}}:</td>
                                    <td><span>${{number_format($order->traveler_reward,2)}}</span></td>
                                </tr>
                                </tbody>
                                <tbody>
                                <tr>
                                    <td>
                                        <small> {{trans("index.tu")}}</small>
                                    </td>
                                    <td>{{($order->from_location) ? $order->from_location->name:trans("index.batkydau")}}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <small> {{trans("index.den")}}</small>
                                    </td>
                                    <td> {{$order->to_location->name}}</td>
                                </tr>
                                @if($order->deliver_date)
                                    <tr>
                                        <td>
                                            <small>{{trans("index.ngaygiaohang")}}</small>
                                        </td>
                                        <td>{{date("d-m-Y", strtotime($order->deliver_date))}}</td>
                                    </tr>
                                @endif
                                @if($order->link)
                                    <tr>
                                        <td>
                                            <small>{{trans("index.muatu")}}</small>
                                        </td>
                                        <td><a target="_blank"
                                               href="{{trim($order->link)}}"> {{parse_url(trim($order->link), PHP_URL_HOST)}}</a>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="text-center">
                                @if(Session::has("userFrontend"))
                                    @if(!($order->shopper_id==Session::get("userFrontend")["account_id"]))
                                        @if($isOffer)
                                        @else
                                            <a href="{{URL::action("Frontend\TravelerController@offer",$order->order_id)}}"
                                               class="btn_style">{{trans("index.nhanmuaho")}}</a>
                                        @endif
                                    @else
                                        @if($order->order_status==1||$order->order_status==-1)
                                            @if($order->order_status==1)
                                                <a href="{{URL::action("Frontend\ShopperController@editOrder",$order->order_id)}}"
                                                   {{--onclick="return confirm('{{trans("index.edit_order_confirm")}}');"--}}
                                                   role="button" class="btn_style">
                                                    {{trans("index.suayeucau")}}
                                                </a>
                                                <br>
                                            <br>
                                                <a href="{{URL::action("Frontend\ShopperController@deactiveOrder",$order->order_id)}}"
                                                   onclick="return confirm('{{trans("index.edit_order_confirm")}}');"
                                                   role="button" class="btn_style">
                                                    {{trans("index.huyyeucau")}}
                                                </a>
                                            @else
                                                <a href="{{URL::action("Frontend\ShopperController@activeOrder",$order->order_id)}}"
                                                   class="btn_style">{{trans("index.dangyeucau")}}</a>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    <a href="{{URL::action("Frontend\TravelerController@offer",$order->order_id)}}"
                                       class="btn_style">
                                        {{trans("index.nhanmuaho")}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="wrap_ChiTietDonHang">

            <div class="container">
                @if(($offer->count()))
                <h1 class="title_block">
                    {{trans("index.denghidangcho")}}
                </h1>
                @endif
                @if(!($offer->count()))
                    <p class="text-center"><i>{{trans("index.chuacodenghinao")}}</i></p>
                    <br>
                @else
                    @if($order->order_status>0)

                            <div class="list_denghi_doi">
                                @foreach($offer as $item)
                                <div class="item_denghi">
                                    <div class="wrap_info_donhang">
                                        <div class="user_item">
                                            <a class="img_user" href="{{URL::action("Frontend\UserController@userRateDetail",$item->account->account_id)}}">
                                                <img src="{{URL::to($item->account->avatar)}}" alt="">
                                            </a>
                                            <div class="name_datetime">
                                                <a class="name_user" href="#">{{$item->account->first_name}} {{$item->account->last_name}}</a>
                                                <span class="datetime">
                                        {{trans("index.dadenghi")}}: {{reltativeDate(date("d-m-Y H:i:s",strtotime($item->offer_time)))}}
                                    </span>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td>Tổng tiền công</td>
                                                <td><span>${{$item->shipping_fee+$item->tax+$item->others_fee}}</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <small>{{trans("index.tongtiencongnhanduocdabaogom")}}

                                                        @if($item->shipping_fee)
                                                        <span>${{$item->shipping_fee}}</span>
                                                            {{trans("index.phivanchuyennoidia")}}
                                                    @endif

                                                    @if($item->tax)
                                                        <span>${{$item->tax}}</span>
                                                         {{trans("index.thue")}}
                                                        @endif
                                                    </small>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tbody>
                                            @if(Session::has("userFrontend"))
                                                @if($order->shopper_id==Session::get("userFrontend")["account_id"])
                                                <tr>
                                                    <td>
                                                        <small>{{trans("index.lienlac")}}</small>
                                                    </td>
                                                    <td>{{$item->account->email}}</td>
                                                </tr>
                                                @endif
                                            @endif
                                            <tr>
                                                <td>
                                                    <small>{{trans("index.tu")}}</small>
                                                </td>
                                                <td>{{($item->from_location)?$item->from_location->name:trans("index.batkydau")}}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <small>{{trans("index.den")}}</small>
                                                </td>
                                                <td>{{($order->to_location->name)?$order->to_location->name:""}}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <small>{{trans("index.ngaygiaohang")}}</small>
                                                </td>
                                                <td>{{date("d-m-Y",strtotime($item->deliver_date))}}</td>
                                            </tr>
                                            @if($item->deliver_details)
                                            <tr>
                                                <td colspan="2">
                                                    <small>{{trans("index.note")}}</small>
                                                    <p>{!! $item->deliver_details !!}</p>
                                                </td>
                                            </tr>
                                            @endif
                                            @if(Session::has("userFrontend"))
                                                @if($order->shopper_id==Session::get("userFrontend")["account_id"])
                                                    <a href="{{URL::action("Frontend\ShopperController@acceptOffer",$item->offer_id)}}"
                                                       class="btn_style">{{trans("index.chapnhandenghi")}}</a>
                                                @endif
                                                @if($item->traveler_id==Session::get("userFrontend")["account_id"])
                                                    <a href="{{URL::action("Frontend\TravelerController@cancelOffer",$item->offer_id)}}"
                                                       class="btn_style">
                                                        <i class="fa fa-times"></i>
                                                        {{trans("index.huydenghi")}}
                                                    </a>
                                                @endif
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                    @endif
                @endif
            </div>
        </div>

    </div>


@endsection
