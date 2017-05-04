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
    <div class=" shopper-banner" style="height: 150px; background-position: top">
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
    <div class="container">
      
        @foreach($where_buy as $key => $item)
            @if($key%4==0)
                <div class="row search-content-3">
                    @endif
                    <div class="col-md-3">
                        <div class="tile-container">
                            <div class="tile-thumbnail">
                                <a href="{{URL::action('Frontend\CollectionsController@detail_where_buy', $item['location_id'])}}">
                                    <img src="{{$item['image']}}"/>
                                </a>
                            </div>
                            <div class="tile-title">
                                <h3>
                                    <a href="{{URL::action('Frontend\CollectionsController@detail_where_buy', $item['location_id'])}}">{{$item['name']}}</a>
                                </h3>

                                <div class="tile-desc">
                                    <p> {{count($item['websites']) . ' websites'}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($key%4==3 || $key == count($where_buy) - 1)
                </div>
            @endif
        @endforeach
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
@endsection