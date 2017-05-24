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
                                    @foreach($item->item_images as $image)
                                        <div class="item">

                                            <a href="#">
                                                <img src="{{$image->image}}" alt="">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="info_product">
                                <h3 class="name_product">
                                    <a href="#">{{$item->name}}</a>
                                </h3>
                                <p>
                                    {!! $item->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-5 col-md-4 col-md-offset-1">
                        <div class="portlet light">
                            {!! Form::open(['action' => 'Frontend\ShopperController@order', 'method' => 'GET',"data-toggle"=>"validator"]) !!}
                            <input type="hidden" name="item" value="{{$item->item_id}}">
                            <div style="min-height: 50px; padding-bottom: 10px;  border-bottom: 1px solid #eee">
                                <div class="font-red" style="float: right; font-size: 20px">
                            <span style="font-weight: 500; " class="text-right">
                                <span class="text-right"
                                      @if($item->is_sale) style="text-decoration: line-through; font-size: small;color: gray;" @endif>
                                    ${{number_format($item['price'], 2)}}</span>
                                @if($item->is_sale)
                                    <br>
                                    <span>${{number_format($item['price_sale'], 2)}}</span>
                                @endif
                            </span>

                                </div>
                                <div style="margin-right:50px; font-size: 13px">
                                    {{trans("index.giasanphamtu")}} <br>
                                    <a class="font-red" href="{{$item->link}}" target="_blank">{{getDomain($item->link)}}</a>
                                </div>
                                <div class="clear" style="clear: both"></div>
                            </div>
                            <div class="form-group margin-top-10">
                                <p>{{trans("index.soluong")}}</p>
                                <div class="btn-group" id="quantityItem">
                                    <button type="button" class="btn red btn-outline bold" id="quantityMinus"
                                            style="min-width: 34px">-
                                    </button>
                                    <input type="text" name="quantity" id="quantity" class="btn btn-default border-red"
                                           value="{{isset($order["quantity"])?$order["quantity"]:"1"}}"
                                           style="width: 40px">
                                    <button type="button" class="btn red btn-outline bold" id="quantityPlus">+</button>
                                </div>
                                <hr>
                                <button type="submit"
                                        class="btn btn-lg btn-block red">{{trans("index.dathang2")}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>


@endsection
