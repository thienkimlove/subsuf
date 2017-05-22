@extends('v2.template')

@section('content')
    <div class="wrap_container">
        <div class="menuVertical_and_sliderBanner">
            <div class="container">
                <div class="menuVertical sidebar-nav">
                    <ul class="nav">
                        @foreach ($categories as $category)
                            @if($category->name == 'Trung tâm mua sắm lớn')
                                @continue
                            @endif
                            <li>
                                <a href="{{url('collections/featured-items?category='. $category->category_id)}}">
                                    <img class="icon" src="{{url($category->image)}}" height="41" width="33" alt="">
                                    <span>{{$category->name}}</span>
                                </a>
                            </li>
                        @endforeach

                        {{--<li><a href="{{url('collections/featured-items')}}">Xem tất cả danh mục</a></li>--}}
                    </ul>
                </div>
                <div class="sliderBanner">
                    <div class="owl-carousel owl-theme owl-sliderBanner">
                        <div class="item">
                            <div class="image">
                                <a href="#">
                                    <img src="{{url('v2/images/banner1.jpg')}}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <a href="#">
                                    <img src="{{url('v2/images/banner3.jpg')}}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="image">
                                <a href="#">
                                    <img src="{{url('v2/images/banner2.jpg')}}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrap_service_home">
            <div class="container text-center">
                <h2 class="title_block">
                    "{{trans('index.v2_muabatcuthugi')}}"
                </h2>
                <div class="list_service row">
                    <div class="item col-xs-12 col-sm-6 col-md-4">
                        <div class="image">
                            <a href="#">
                                <img src="{{url('v2/images/icon1_blook_3service.png')}}" alt="">
                            </a>
                        </div>
                        <h3 class="title">
                            <a href="#">{{trans('index.chiphivanchuyenthap')}}</a>
                        </h3>
                        <p class="summary">
                            {{trans("index.chiphivanchuyenthap_detail")}}
                        </p>
                        {{--<a class="btn_link" href="#">{{trans('index.v2_xemthem')}} <i class="fa fa-angle-right" aria-hidden="true"></i></a>--}}
                    </div>
                    <div class="item col-xs-12 col-sm-6 col-md-4">
                        <div class="image">
                            <a href="#">
                                <img src="{{url('v2/images/icon2_blook_3service.png')}}" alt="">
                            </a>
                        </div>
                        <h3 class="title">
                            <a href="#">{{trans('index.nguongocminhbach')}}</a>
                        </h3>
                        <p class="summary">
                            {{trans('index.nguongocminhbach_detail')}}
                        </p>
                        {{--<a class="btn_link" href="#">{{trans('index.v2_xemthem')}} <i class="fa fa-angle-right" aria-hidden="true"></i></a>--}}
                    </div>
                    <div class="item col-xs-12 col-sm-12 col-md-4">
                        <div class="image">
                            <a href="#">
                                <img src="{{url('v2/images/icon3_blook_3service.png')}}" alt="">
                            </a>
                        </div>
                        <h3 class="title">
                            <a href="#">{{trans("index.boihoandaydu")}}</a>
                        </h3>
                        <p class="summary">
                            {{trans("index.boihoandaydu_detail")}}
                        </p>
                        {{--<a class="btn_link" href="#">{{trans('index.v2_xemthem')}} <i class="fa fa-angle-right" aria-hidden="true"></i></a>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="wrap_blog_home color_bg_sub">
            <div class="container">
                <h2 class="title_block">
                    <a href="#">
                        {{trans('index.v2_quytrinhnhanhang')}}
                    </a>
                </h2>
                <div class="list_post_blog row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="item_post">
                            <div class="image_title">
                                <a class="image" href="#">
                                    <img src="{{url('v2/images/banner1.jpg')}}" alt="">
                                </a>
                                <h3 class="title">
                                    <a href="#">{{trans("index.taoyeucau")}}</a>
                                </h3>
                            </div>
                            <div class="summary">
                                <p>{{trans("index.taoyeucau_detail")}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="item_post">
                            <div class="image_title">
                                <a class="image" href="#">
                                    <img src="{{url('v2/images/banner3.jpg')}}" alt="">
                                </a>
                                <h3 class="title">
                                    <a href="#">{{trans("index.chondenghiphuhop")}}</a>
                                </h3>
                            </div>
                            <div class="summary">
                                <p>{{trans("index.chondenghiphuhop_detail")}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="item_post">
                            <div class="image_title">
                                <a class="image" href="#">
                                    <img src="{{url('v2/images/banner2.jpg')}}" alt="">
                                </a>
                                <h3 class="title">
                                    <a href="#">{{trans("index.gapnguoimuahodenhanhang")}}</a>
                                </h3>
                            </div>
                            <div class="summary">
                                <p>{{trans("index.gapnguoimuahodenhanhang_detail")}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrap_produc_home">
            <div class="container">
                <h2 class="title_block">
                    <a href="#">
                        {{trans('index.v2_hanghotgiamgia')}}
                    </a>
                </h2>
                <div class="slider_product">
                    <div class="owl-carousel owl-theme owl_slider_product">
                        @foreach ($saleItems as $saleItem)
                            <div class="item">
                                <div class="box_product">
                                    <div class="image_product">
                                        <a href="{{$saleItem->link}}">
                                            <img src="{{url($saleItem->image)}}" height="236" width="354" alt="">
                                        </a>
                                    </div>
                                    <div class="info_product">
                                        <h3 class="title">
                                            <a href="{{url('item', $saleItem->item_id)}}">{{$saleItem->name}}</a>
                                        </h3>
                                        <a class="link_web"
                                           href="{{$saleItem->link}}">{{ parse_url($saleItem->link, PHP_URL_HOST) }}</a>
                                        <div class="price-box">
                                            <div class="special-price f-left">
                                                <span class="price product-price">${{$saleItem->price_sale}}</span>
                                            </div>
                                            <div class="old-price">
                                            <span class="price product-price-old">
                                                ${{$saleItem->price}}
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{url('collections/sale-items')}}" class="btn_style">{{trans('index.v2_xemtatca')}}</a>
                </div>
            </div>
        </div>

        <div class="wrap_produc_home color_bg_sub">
            <div class="container">
                <h2 class="title_block">
                    <a href="#">
                        {{trans('index.v2_sanphamnoibat')}}
                    </a>
                </h2>
                <div class="slider_product">
                    <div class="owl-carousel owl-theme owl_slider_product">
                        @foreach ($featureItems as $featureItem)
                            <div class="item">
                                <div class="box_product">
                                    <div class="image_product">
                                        <a href="{{url('item', $featureItem->item_id)}}">
                                            <img src="{{url($featureItem->image)}}" height="236" width="354" alt="">
                                        </a>
                                    </div>
                                    <div class="info_product">
                                        <h3 class="title">
                                            <a href="{{url('item', $featureItem->item_id)}}">{{$featureItem->name}}</a>
                                        </h3>
                                        <a class="link_web"
                                           href="{{$featureItem->link}}">{{ parse_url($featureItem->link, PHP_URL_HOST) }}</a>
                                        <div class="price-box">
                                            @if ($featureItem->price_sale)
                                                <div class="special-price f-left">
                                                    <span class="price product-price">${{$featureItem->price_sale}}</span>
                                                </div>
                                                <div class="old-price">
                                            <span class="price product-price-old">
                                                ${{$featureItem->price}}
                                            </span>
                                                </div>
                                            @else
                                                <div class="special-price f-left">
                                                    <span class="price product-price">${{$featureItem->price}}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{url('collections/featured-items')}}" class="btn_style">{{trans('index.v2_xemtatca')}}</a>
                </div>
            </div>
        </div>

        <div class="wrap_exhibition_home">
            <div class="container">
                <h2 class="title_block">
                    <a href="#">
                        {{trans('index.v2_donhangthanhcong')}}
                    </a>
                </h2>
                <div class="slider_exhibition_2u">
                    <div class="owl-carousel owl-theme owl_exhibition_2u">
                        @foreach ($finishOrders as $finishOrder)
                            @if ($offer = $finishOrder->offer)
                                @if ($order = $offer->order)
                                    <div class="item">
                                        <div class="box_exhibition">
                                            <div class="image_exhibition">
                                                <a href="#">
                                                    <img src="{{url($order->order_images[0]->image)}}" height="236"
                                                         width="354" alt="">
                                                </a>
                                            </div>
                                            <div class="info_exhibition">
                                                <div class="wrap_user">
                                                    <div class="user_item text-center">
                                                        <a class="img_user"
                                                           href="{{ url('user-rate', $offer->account->account_id)  }}">
                                                            <img src="{{url($offer->account->avatar)}}" alt="">
                                                        </a>
                                                        <a class="name_user"
                                                           href="{{ url('user-rate', $offer->account->account_id)  }}">{{$offer->account->first_name}} {{$offer->account->last_name}}</a>
                                                        <span class="add">
                                                         {{$offer->from_location["name"]}}
                                                    </span>
                                                    </div>
                                                    <div class="user_item">
                                                        <a class="img_user"
                                                           href="{{ url('user-rate', $order->account->account_id)  }}">
                                                            <img src="{{url($order->account->avatar)}}" alt="">
                                                        </a>
                                                        <a class="name_user"
                                                           href="{{ url('user-rate', $order->account->account_id)  }}">{{$order->account->first_name}} {{$order->account->last_name}}</a>
                                                        <span class="add">
                                                        {{$order->to_location["name"]}}
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="datetime">
                                                    {{date("d-m-Y",strtotime($offer->deliver_date))}}
                                                </div>
                                                <div class="wage">
                                                    {{trans('index.v2_tiencong')}}:
                                                    <span>${{$offer->others_fee+$offer->shipping_fee+$offer->tax}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('frontend_script')
    <script>

        $(document).ready(function () {
            setTimeout(function () {
                var isShowing = Cookies.get('show_popup_secure_4nd', {domain: document.domain});

                if (!isShowing || isShowing === '0') {
                    $('#coupon_popup').modal();
                    Cookies.set('show_popup_secure_4nd', '1', {expires: 7, domain: document.domain});
                }
            }, 4500);


        });

    </script>
@endsection