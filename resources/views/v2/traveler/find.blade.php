


@extends('v2.template')

@section('content')

    <div class="wrap_container">
        <div class="wrap_dathang_NhanMuaHo" style="background-image: url('/v2/images/banner3.jpg');">
            <div class="container">

                <div class="wrap-fomr">
                    <h1 class="title_block">{{trans("index.traveler_slogan")}}</h1>
                    <p>{{trans("index.traveler_slogan2")}}</p>
                    {{Form::open(['action' => 'Frontend\TravelerController@find', 'method' => 'GET', 'class' => 'form_select'])}}

                    <select class="selectpicker select" data-live-search="true" name="deliver_from" >
                        @foreach($country as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <select class="selectpicker select select2" data-live-search="true" name="deliver_to">
                        @foreach($province as $key1 => $value1)
                            <option value="{{ $key1 }}">{{ $value1 }}</option>
                        @endforeach
                    </select>


                    {{--{{Form::select("deliver_from",$country,null,["data-live-search"=> "true","class"=>"selectpicker select", "placeholder"=>""])}}--}}
                    {{--{{Form::select("deliver_to",$province,null,["data-live-search"=> "true","class"=>"selectpicker select", "placeholder"=>""])}}--}}


                    <button type="submit" class="btn btn_dathang">{{trans("index.timkiemdonhang")}}</button>
                    {{ Form::close() }}
                    <div class="text-center">
                    <a class="btn_link" href="#"></a>
                    </div>
                </div>
            </div>
        </div>


        <div class="wrap_exhibition_home color_bg_sub">
            <div class="container">
                <h2 class="title_block">



                </h2>
                <div class="slider_exhibition_u">
                    <div class="row">
                        @foreach($orderList as $order)
                            <div class="item col-xs-12 col-sm-6 col-md-4">
                                <div class="box_exhibition" style="height: 544px">
                                    <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">
                                        <div class="image_exhibition" style="height: 240px; width: 360px; background-repeat: no-repeat; background-size: cover; background-position: center; @if(count($order->order_images))background-image: url('{{URL::to($order->order_images[0]->image)}}' @endif)">
                                            {{--<a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">--}}
                                            {{--<img src="@if(count($order->order_images)) {{URL::to($order->order_images[0]->image)}} @endif"/>--}}
                                            {{--</a>--}}

                                        </div>
                                    </a>
                                    <div class="info_exhibition">
                                        <div class="wrap_user">
                                            <div class="user_item">
                                                <a href="#" class="img_user">
                                                    <img alt="" class="img-circle" src="{{URL::to($order->account["avatar"])}}">

                                                </a>
                                                <div class="name_datetime">
                                                    <a class="name_user" href="#">{{$order->account["first_name"]}} {{$order->account["last_name"]}}</a>
                                                    <span class="datetime">
                                                    {{reltativeDate(date("d-m-Y H:i:s",strtotime($order->request_time)))}}
                                                </span>
                                                </div>
                                            </div>
                                            <h4 class="name_product">
                                                <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">{{ \Illuminate\Support\Str::words($order->name, 10)}}</a>
                                            </h4>
                                            <div class="to_from">
                                                <span class="to">{{$order->to_location->name}}</span>
                                                đến
                                                <span class="from">@if($order->from_location) {{$order->from_location->name}} @else
                                                        {{trans("index.batkydau")}} @endif</span>
                                            </div>
                                        </div>
                                        <div class="wage">


                                            @if($order->offers->count()==0)

                                                {{trans('index.traveler_reward')}}:


                                                <span>${{$order->traveler_reward}}</span>

                                            @elseif($order->offers->count()==1)

                                                <span>{{$order->offers->count()}}</span>
                                                {{trans("index.denghi")}}, {{trans("index.tiencong")}}:
                                                <span>${{$order->offers[0]->shipping_fee+$order->offers[0]->others_fee+$order->offers[0]->tax}}</span>

                                            @else
                                                @php
                                                    $minOffer = 0;
                                                    $maxOffer = 0;
                                                    foreach ($order->offers as $offer) {
                                                        $offerVal = $offer->shipping_fee + $offer->others_fee + $offer->tax;
                                                        if ($minOffer == 0 || $minOffer > $offerVal) $minOffer = $offerVal;
                                                        if ($maxOffer == 0 || $maxOffer < $offerVal) $maxOffer = $offerVal;
                                                    }
                                                @endphp
                                                <span>{{$order->offers->count()}}</span>
                                                {{trans("index.denghi_n")}}, {{trans("index.tiencong")}}: {{trans("index.tu")}} <span>${{$minOffer}}</span> {{trans("index.den")}} <span>${{$maxOffer}}</span>

                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}" class="btn_style">{{trans("index.nhanmuaho")}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <nav class="text-center" aria-label="Page navigation">
                        @include('pagination.default', ['paginator' => $orderList])
                    </nav>
                </div>
            </div>
        </div>

    </div>




@endsection