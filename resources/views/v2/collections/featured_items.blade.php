@extends('v2.template')

@section('style')

    <link rel="stylesheet" href="/v2/css/profile.css">
    <link rel="stylesheet" href="/v2/css/component.css">
    <link rel="stylesheet" href="/v2/css/custom.css">
    <link rel="stylesheet" href="/v2/css/about.min.css">

@endsection
@section('content')
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper"><!-- BEGIN HEADER TOP -->
                    <!-- BEGIN CONTENT BODY -->

                    <!-- BEGIN PAGE CONTENT BODY -->
                    <div class="page-content">

                        <div class="shopper-banner" style="height: 150px !important; background-position: top">
                            <div class="col-xs-12 col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
                                <div class="nav-justified" style="margin-top: 50px;" id="tabIndex">
                                    <div class="tab-content">
                                        <h2 class="first-slogan">
                                            {{$title}}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container" style="padding-top: 20px">
                            <div class="row">
                                <div class="col-md-12 text-center margin-bottom-20">
                                    @foreach($category_item as $cat)
                                        <span class="btn btn-circle  red @if(!in_array($cat->category_id, $arr_category))  btn-outline  @endif btn-hanghot">
                                <a class=" @if(in_array($cat->category_id, $arr_category)) font-white @endif"
                                   href="@if($query_category == '') {{URL::current(). '?category=' . $cat->category_id}}
                                   @elseif(!in_array($cat->category_id, $arr_category))
                                   {{URL::current(). '?category=' . $query_category. ',' . $cat->category_id}}
                                   @endif">
                                    <span class="@if(in_array($cat->category_id, $arr_category)) bold @endif">
                                        {{$categories[$cat->category_id]['name']}}
                                    </span>
                                </a>
                                            @if(in_array($cat->category_id, $arr_category))
                                                <?php
                                                $new_query = str_replace("$cat->category_id", "", $query_category);
                                                $new_query = str_replace(",,", ",", $new_query)
                                                ?>
                                                <a class="font-white"
                                                   href="{{URL::current(). '?category=' . trim($new_query, ",")}}">
                                        <i class="fa fa-close"></i>
                                    </a>
                                            @endif
                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <?php $i = 0 ?>
                            @foreach($items as $key => $item)
                                @if(!empty($arr_category) && !in_array($item['category_id'], $arr_category))
                                    @continue
                                @endif
                                @if($i%4==0)
                                    <div class="row search-content-3">
                                        @endif
                                        <div class="col-md-3">
                                            <div class="tile-container  item-box">
                                                <div class="tile-thumbnail">
                                                    <a href="{{URL::action("Frontend\ItemController@item",$item["item_id"])}}">
                                                        <img src="{{$item['image']}}"/>
                                                    </a>
                                                </div>
                                                <div class="tile-title">
                                                    <h3>
                                                        <a href="{{URL::action("Frontend\ItemController@item",$item["item_id"])}}">
                                                            {{$item['name']}}
                                                        </a>
                                                    </h3>

                                                    <div class="tile-desc">
                                                        <p> {{get_host($item['link'])}}</p>
                                                        <p>
                                        <span @if($item->is_sale) style="text-decoration: line-through"
                                              @else class="font-green bold" @endif> ${{number_format($item['price'])}}</span>
                                                            @if($item->is_sale)
                                                                <span class="font-red bold">${{number_format($item['price_sale'])}}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if($i%4==3 || $key == count($item->items) - 1)
                                    </div>
                                @endif
                                <?php $i++; ?>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('frontend_script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
@endsection