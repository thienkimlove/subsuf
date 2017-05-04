@extends('frontend.layout.template')
@section('style')

    {{Html::style('assets/global/plugins/owlcarousel/assets/owl.carousel.css')}}
    {{Html::style('assets/global/plugins/owlcarousel/assets/owl.theme.default.css')}}
    {{Html::style('assets/pages/css/profile.min.css')}}
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
    <div class="container margin-top-20 order-detail-block">
        @include("frontend.message")
        <div class="row">
            <div class="col-md-7">
                <div class="portlet light item-detail">
                    <div class="portlet-body">
                        <div @if($item->item_images->count()>1)id="olwcarousel"@endif>
                            @if($item->item_images->count()==0)
                                <div><img src="{{$item->image}}" style="width: 100%;"></div>
                            @endif
                            @foreach($item->item_images as $image)
                                <div><img src="{{$item->image}}" style="width: 100%; max-height: 500px"></div>
                            @endforeach
                        </div>
                        <div class="row">
                            <hr>
                            <div class="col-lg-12">
                                <h2>{{$item->name}}</h2>
                                <p>
                                    {!! $item->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
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
@endsection

@section('script')
    {{Html::script('assets/global/plugins/owlcarousel/owl.carousel.min.js')}}
    <script type="text/javascript">
        $("#olwcarousel").owlCarousel({
            loop: true,
            nav: true,
            margin: 30,
            items: 1
        });
        $("#quantityPlus").click(function () {
            var quantity = parseInt($("#quantity").val());
            if (quantity < 9) {
                $("#quantity").val(quantity + 1);
            }
        });
        $("#quantityMinus").click(function () {
            var quantity = parseInt($("#quantity").val());
            if (quantity > 1) {
                $("#quantity").val(quantity - 1);
            }
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