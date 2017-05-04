@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/pages/css/search.min.css')}}
@endsection
@section('breadcrumb')

@endsection

@section('content')
    <div class=" shopper-banner" style="height: 150px !important; background-position: top">
        <div class="col-xs-12 col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
            <div class="nav-justified" style="margin-top: 50px;" id="tabIndex">
                <div class="tab-content">
                    <h2 class="first-slogan">
                        {{$title}}: {{$location->name}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center margin-top-20 margin-bottom-20" id="checkList">
            @foreach($category_location as $cat)
                    <span class="btn btn-circle red @if(!in_array($cat->category_id, $arr_category))  btn-outline  @endif">

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
                                    <a class=" @if(in_array($cat->category_id, $arr_category)) font-white @endif"
                                       href="{{URL::current(). '?category=' . trim($new_query, ",")}}">
                                        <i class="fa fa-check"></i>
                                    </a>
                                @endif
</span>
                        @endforeach

            </div>
        </div>

        <?php $i = 0 ?>

        @foreach($location->websites as $key => $item)
            @if(!empty($arr_category) && !in_array($item['category_id'], $arr_category))
                @continue
            @endif
            @if($i%4==0)
                <div class="row search-content-3">
                    @endif
                    <div class="col-md-3">
                        <div class="tile-container">
                            <div class="tile-thumbnail">
                                <a href="{{$item['link']}}" target="_blank">
                                    <img src="{{$item['image']}}"/>
                                </a>
                            </div>
                            <div class="tile-title" >
                                <h3 style="height: 30px">
                                    <a href="{{$item['link']}}" target="_blank">{{$item['name']}}</a>
                                </h3>

                                <div class="tile-desc" style="min-height: 40px">
                                <p> {{($item['description'])}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($i%4==3 || $key == count($location->websites) - 1)
                </div>
            @endif
            <?php $i++; ?>
        @endforeach
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
@endsection