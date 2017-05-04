@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/global/plugins/owlcarousel/assets/owl.carousel.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/pages/css/search.min.css')}}
@endsection
@section('breadcrumb')
@endsection

@section('content')
    <div class=" shopper-banner" style="height: 620px;">
        <div class="col-xs-12 col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
            <div class="nav-justified" style="margin-top: 150px;" id="tabIndex">
                <div class="tab-content">
                    <h2 class="first-slogan">
                        {{trans("index.shopper_slogan")}}
                    </h2>

                    <div class="text-xs-center second-slogan">
                        <p class="font-size-lg m-b-2 p-x-1 hidden-xs">
                                <span>
                                     {{trans("index.shopper_slogan2")}}

                                </span>
                    </div>
                    {{Form::open(['action' => 'Frontend\ShopperController@order', 'method' => 'GET'])}}
                    <br>
                    <div class="input-group input-group-lg hidden-xs">
                        <input type="text" name="url" class="form-control"
                               placeholder="{{trans("index.nhaplinksp")}}">
                        <span class="input-group-btn">
                                <button class="btn red" type="submit" name="start"
                                        value="1">{{trans("index.batdaudathang")}}</button>
                            </span>
                    </div>
                    {{Form::close()}}
                    {{Form::open(['action' => 'Frontend\ShopperController@order', 'method' => 'GET'])}}

                    <div class="form-group hidden-lg hidden-md hiddent-sm">
                        <input type="text" name="url" class="form-control"
                               placeholder="{{trans("index.nhaplinksp")}}">
                    </div>

                    <div class="form-group hidden-lg hidden-md hiddent-sm text-center">
                        <button class="btn red" type="submit" name="start"
                                value="1">{{trans("index.batdaudathang")}}</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row margin-top-40 stories-header" data-auto-height="true">
            <div class="col-md-12">
                <h1>{{trans("index.sanphamdanghot")}}</h1>
            </div>
        </div>
        <div class=" search-content-3 olwcarousel" id="sanphamhot">
            @foreach($items as $key => $item)
                <div class="item tile-container  item-box">
                    <div class="tile-thumbnail">
                        <a href="{{URL::action("Frontend\ItemController@item",$item["item_id"])}}">
                            <img src="{{$item['image']}}"/>
                        </a>
                    </div>
                    <div class="tile-title">
                        <h3>
                            <a href="{{URL::action("Frontend\ItemController@item",$item["item_id"])}}">{{$item['name']}}</a>
                        </h3>
                        <div class="tile-desc">
                            <p> {{get_host($item['link'])}}</p>
                            <p class="font-green bold"> ${{number_format($item['price'], 2)}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class=" text-center">
            <a href="{{URL::action('Frontend\CollectionsController@featured_items')}}" class="btn red btn-lg"
               style="width: 40%">{{trans("index.xemtatca")}}</a>
        </div>
    </div>
    <div class="">
        <div class="container">
            <div class="row margin-top-40 stories-header" data-auto-height="true">
                <div class="col-md-12">
                    <h1>{{trans("index.danhmuchanghoa")}}</h1>
                    {{--<p>{{trans("index.danhmuchanghoa_detail")}}</p>--}}
                </div>
            </div>
            <div class="row search-content-3">
                <div class="col-lg-12  olwcarousel">
                    @foreach($buy_where as $key => $item)
                        @if($key == 8)
                            @break
                        @endif
                        <div class="item tile-container">
                            <div class="tile-thumbnail">
                                <a href="{{URL::action('Frontend\CollectionsController@detail_buy_where', $item['category_id'])}}">
                                    <img src="{{$item['image']}}"/>
                                </a>
                            </div>
                            <div class="tile-title">
                                <h3>
                                    <a href="{{URL::action('Frontend\CollectionsController@detail_buy_where', $item['category_id'])}}">{{$item['name']}}</a>
                                </h3>

                                <div class="tile-desc">
                                    <p> {{count($item['websites']) . ' websites'}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{--<div class="row text-center">--}}
            {{--<a href="{{URL::action('Frontend\CollectionsController@buy_where')}}" class="btn btn-danger btn-lg"--}}
            {{--style="width: 40%">Xem tất cả</a>--}}
            {{--</div>--}}
        </div>
    </div>
    <div class="">

        <div class="container">
            <div class="row margin-top-20 stories-header" data-auto-height="true">
                <div class="col-md-12">
                    <h1>{{trans("index.quocgia")}}</h1>
                    <p></p>
                </div>
            </div>

            <div class="row stories-cont" id="quocgia">
                @foreach($where_buy as $key => $item)
                    <?php if ($key >= 3) break; ?>
                    <div class="col-md-4">
                        <div class="portlet light">
                            <div class="photo">
                                <a href="{{URL::action('Frontend\CollectionsController@detail_where_buy', $item['location_id'])}}">
                                    <img src="{{$item['image']}}" alt="" class="img-responsive"
                                         style="width: 160px; height: 160px"></div>
                            </a>
                            <div class="title">
                                <a href="{{URL::action('Frontend\CollectionsController@detail_where_buy', $item['location_id'])}}">
                                    <span> {{$item['name']}} </span>
                                </a>
                            </div>
                            <div class="desc">
                                <span> {{count($item['websites']) . ' websites'}} </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{--<div class="row text-center">--}}
            {{--<a href="{{URL::action('Frontend\CollectionsController@where_buy')}}" class="btn btn-danger btn-lg"--}}
            {{--style="width: 40%">Xem tất cả</a>--}}

            {{--</div>--}}
        </div>
    </div>

    <div class="container">
        <div class="row margin-top-20 stories-header" data-auto-height="true">
            <div class="col-md-12">
                <h1>{{trans("index.sanphamgiamgiamoingay")}}</h1>

            </div>
        </div>
        <div class="row search-content-3 olwcarousel">
            @foreach($items_sale as $key => $item)
                <div class="item tile-container item-box">
                    <div class="tile-thumbnail">
                        <a href="{{URL::action('Frontend\ItemController@item', $item['item_id'])}}">
                            <img src="{{$item['image']}}"/>
                        </a>
                    </div>
                    <div class="tile-title">
                        <h3>
                            <a href="{{URL::action('Frontend\ItemController@item', $item['item_id'])}}">
                                {{$item['name']}}</a>
                        </h3>

                        <div class="tile-desc">
                            <p> {{get_host($item['link'])}}</p>
                            <p>
                                <span @if($item->is_sale) style="text-decoration: line-through"
                                      @else class="font-green bold" @endif> ${{number_format($item['price'], 2)}}</span>
                                @if($item->is_sale)
                                    <span class="font-red bold">${{number_format($item['price_sale'], 2)}}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row text-center">
            <a href="{{URL::action('Frontend\CollectionsController@sale_items')}}" class="btn btn-danger btn-lg"
               style="width: 40%">{{trans("index.xemtatca")}}</a>
        </div>
    </div>

@endsection

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/global/plugins/owlcarousel/owl.carousel.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    <script type="text/javascript">
        $(".olwcarousel").owlCarousel({
            loop: true,
            nav: false,
            margin: 30,
            responsiveClass: true,
            navText: ['<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false
                }
            }
        })
    </script>
    <style>
        .owl-prev {
            position: absolute;
            bottom: 50%;
            left: -40px;
            color: #c0d2ea;
            font-size: 50px;
        }

        .owl-next {
            position: absolute;
            bottom: 50%;
            right: -40px;
            color: #c0d2ea;
            font-size: 50px;

        }

        .owl-prev:hover {
            color: #e7505a !important;;
            left: -42px;

        }

        .owl-next:hover {
            color: #e7505a !important;;
            right: -42px;
        }

    </style>
@endsection