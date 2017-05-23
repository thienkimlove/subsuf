
@extends('v2.template')

@section('content')
<div class="wrap_container">
    <div class="menuVertical_and_sliderBanner">
        <div class="container">
            <div class="menuVertical sidebar-nav">
                <ul class="nav">
                    @foreach ($categories as $category)
                        @if($category->category_id == 7)
                            @continue
                        @endif
                        <li>
                            <a href="{{URL::current().'?category='. $category->category_id}}">
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

                                <img src="{{url('v2/images/banner1.jpg')}}" alt="">

                        </div>
                    </div>
                    <div class="item">
                        <div class="image">

                                <img src="{{url('v2/images/banner3.jpg')}}" alt="">

                        </div>
                    </div>
                    <div class="item">
                        <div class="image">

                                <img src="{{url('v2/images/banner2.jpg')}}" alt="">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="wrap_blog_home">
        <div class="container">
            <h2 class="title_block">

                    {{$title}}

            </h2>
            <div class="list_products row">
                @foreach($items as $key => $item)
                    @if(!empty($arr_category) && !in_array($item['category_id'], $arr_category))
                        @continue
                    @endif
                <div class="col-xs-12 col-sm-6 col-md-4" style="height: 496px">
                    <div class="item_pr item">
                        <div class="image_title">
                            <a class="image" href="{{URL::action("Frontend\ItemController@item",$item["item_id"])}}">

                                <div style="height: 288px; width: 360px; background-repeat: no-repeat; background-size: cover; background-position: center; background-image: url('{{$item['image']}}')"></div>


                            </a>

                        </div>
                        <div class="summary">
                            <h3 class="title">
                                {{\Illuminate\Support\Str::words($item['name'], 8)}}
                            </h3>
                            <p class="site">{{get_host($item['link'])}}</p>

                            <div><span class="main-price">${{number_format($item['price'])}}</span> &nbsp;  @if($item->is_sale)<span class="old-price">${{number_format($item['price_sale'])}}</span>@endif </div>
                        </div>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
    </div>



</div>
@endsection