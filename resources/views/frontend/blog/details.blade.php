@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
@endsection
@section('breadcrumb')

@endsection

@section('content')
    <div class="container">
        <div class="blog-page blog-content-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-single-content bordered blog-container">
                        <div class="blog-single-head">
                            <h1 class="blog-single-head-title">
                                {{$chose_blog->title}}
                            </h1>

                            <div class="blog-single-head-date">
                                <i class="icon-calendar font-blue"></i>
                                <a href="#" class="font-blue">
                                    {{date("d-m-Y", strtotime($chose_blog->time_created))}}
                                </a>
                            </div>
                        </div>
                        <div class="blog-single-desc">
                            {!! $chose_blog->content !!}
                        </div>
                        <div class="blog-single-foot">
                            <ul class="blog-post-tags">
                                <li class="uppercase">
                                    <a href="{{URL::action('Frontend\BlogController@category', $chose_blog->category->slug)}}">
                                        {{$chose_blog->category->name}}
                                    </a>
                                </li>
                                {{--<li class="uppercase">--}}
                                {{--<a href="javascript:;">Sass</a>--}}
                                {{--</li>--}}
                                {{--<li class="uppercase">--}}
                                {{--<a href="javascript:;">HTML</a>--}}
                                {{--</li>--}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection