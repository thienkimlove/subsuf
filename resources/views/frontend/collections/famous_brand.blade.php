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
    <div class="container">
        <div class="row stories-header" data-auto-height="true">
            <div class="col-md-12">
                <h1>{{$title}}</h1>
            </div>
        </div>

        @foreach($brands as $key => $item)
            @if($key%4==0)
                <div class="row search-content-3">
                    @endif
                    <div class="col-md-3">
                        <div class="tile-container">
                            <div class="tile-thumbnail">
                                <a href="{{URL::action('Frontend\CollectionsController@detail_famous_brand', $item['brand_id'])}}">
                                    <img src="{{$item['logo']}}"/>
                                </a>
                            </div>
                            <div class="tile-title">
                                <h3>
                                    <a href="{{URL::action('Frontend\CollectionsController@detail_famous_brand', $item['brand_id'])}}">
                                        {{$item['name']}}</a>
                                </h3>

                                <div class="tile-desc">
                                    <p> {{count($item['items']) . ' '.trans("index.sanpham")}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($key%4==3 || $key == count($brands) - 1)
                </div>
            @endif
        @endforeach
    </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
@endsection