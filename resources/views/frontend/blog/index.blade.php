@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
@endsection
@section('breadcrumb')

@endsection

@section('content')
    <div class="container">
        <div class="blog-page blog-content-1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="blog-banner blog-container"
                                 style="background-image:url(/assets/pages/img/background/46.jpg);">
                                <h2 class="blog-title blog-banner-title">
                                    <a href="javascript:;">
                                        @if(isset($chose_category))
                                            {{$chose_category->name}}
                                        @else
                                            Blog
                                        @endif
                                    </a>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 text-center margin-bottom-30">
                            @foreach($categories as $category)
                                <span class="btn btn-circle red @if(!isset($chose_category)
                                || (isset($chose_category) && $category->category_id != $chose_category->category_id))
                                        btn-outline @endif">
                                <a class="@if(isset($chose_category) && $category->category_id == $chose_category->category_id) font-white @endif"
                                   href="{{URL::action('Frontend\BlogController@category', $category->slug)}}">
                                    <span class="">
                                        {{$category->name}}
                                    </span>
                                </a>
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        @foreach($blog_list as $blog)
                            <div class="col-sm-4">
                                <div class="blog-post-sm bordered blog-container">
                                    <div class="blog-img-thumb">
                                        <a href="javascript:;">
                                            <img src="{{$blog->image}}">
                                        </a>
                                    </div>
                                    <div class="blog-post-content">
                                        <h2 class="blog-title blog-post-title">
                                            <a href="{{URL::action('Frontend\BlogController@blog_details', $blog->slug)}}">
                                                {{$blog->title}}
                                            </a>
                                        </h2>
                                        <p class="blog-post-desc">
                                            {{$blog->short_description}}
                                        </p>
                                        <div class="blog-post-foot">
                                            <div class="blog-post-meta">
                                                <i class="icon-calendar font-blue"></i>
                                                <a href="#" class="font-blue">
                                                    {{date("d-m-Y", strtotime($blog->time_created))}}
                                                </a>
                                            </div>
                                            {{--<div class="blog-post-meta">--}}
                                            {{--<i class="icon-bubble font-blue"></i>--}}
                                            {{--<a href="javascript:;">14 Comments</a>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="text-center col-xs-12">
                            {!!  $blog_list->appends(Request::except('page'))->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection