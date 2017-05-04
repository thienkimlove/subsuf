@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/global/plugins/rateit/rateit.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/pages/css/search.min.css')}}
    <style type="text/css">
        #orderDetail h2 {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #69717e;
        }

        .content-right {
            font-size: 14px;
            float: right;
            text-transform: none;
        }

        #orderDetail .col-xs-12 h2 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .shopperclick, .travelerclick {
            cursor: pointer !important;
            font-weight: bold;
        }
        .shopperclick .badge .fa-caret-up,.travelerclick .fa-caret-up{
            position: absolute;
            bottom:0;
        }

        .shopperclick .badge, .travelerclick .badge {
            float: left;
            margin-top: 5px;
        }

        .shopperclick:hover, .travelerclick:hover {
            text-decoration: none;
            color: #d90700;

        }
        .box{
            border:solid 1px black;
            position:relative;
            display:block;
            height:100px;
            width:100px;
            margin-left:5px;
            background: #fff;
        }
        .box:before{
            content:"";
            display:inline-block;
            position:absolute;
            border:10px solid black;
            border-color:transparent transparent black transparent ;
            bottom:0;
            left: 50%;
        }

    </style>
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

    <div class="container white">
        <div class="row margin-top-40">
            <div class="col-lg-8 col-lg-offset-2">
                <div class=" bg-grey-steel" style=" padding: 10px">
                    {{--<div class="box"></div>--}}
                    <div style="width:300px; margin: 20px auto;">
                        <div class="text-center">
                            <img class="img-circle" src="{{URL::to($user->avatar)}}"
                                 style="width: 50px; height: 50px;">
                            <br>
                            <p class="bold">
                                {{$user->first_name}} {{$user->last_name}}
                            </p>
                            <div class="row">
                                <div class="col-xs-6 text-center shopper-box">
                                    <a class="shopperclick">
                                        <span class="badge badge-danger">{{$user->rate()->where("type","shopper")->count()}}</span>
                                        <div class="rateit" data-rateit-mode="font" data-rateit-value="{{$starShopper}}"
                                             data-rateit-readonly="true">
                                        </div>
                                        <br>
                                        <p class=" shopperclick">
                                            {{trans("index.shopper")}}
                                        </p>
                                    </a>
                                </div>
                                <div class="col-xs-6 text-center travelerclick">
                                    <a class="travelerclick">
                                        <span class="badge badge-danger">{{$user->rate()->where("type","traveler")->count()}}</span>

                                        <div class="rateit" data-rateit-mode="font"
                                             data-rateit-value="{{$starTraveler}}"
                                             data-rateit-readonly="true">
                                        </div>
                                        <p class="travelerclick">
                                            {{trans("index.traveler")}}
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portlet light bordered">

                    <div class="portlet-body">
                        @include("frontend.message")
                        <div class="tab-content">
                            <div class="tab-pane active" id="shopper_comment">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-bubbles font-dark hide"></i>
                                        {{--<h3 style="border-bottom:1px solid #eee; padding-bottom: 10px"--}}
                                            {{--class="caption-subject font-dark  uppercase">{{trans("index.shopperreview")}}</h3>--}}
                                    </div>
                                </div>
                                <!-- BEGIN: Comments -->
                                @foreach($user->rate()->where("type","shopper")->get() as $shopperComment)

                                    <div class="mt-comments">
                                        <div class="mt-comment">
                                            <div class="mt-comment-img">
                                                <img src="{{URL::to($shopperComment->user_rate->avatar)}}"></div>
                                            <div class="mt-comment-body">
                                                <div class="mt-comment-info">
                                                    <span class="mt-comment-author">{{$shopperComment->user_rate->first_name}} {{$shopperComment->user_rate->last_name}}</span>
                                                    <span class="mt-comment-date"><div class="rateit"
                                                                                       data-rateit-mode="font"
                                                                                       data-rateit-readonly="true"
                                                                                       data-rateit-value="{{$shopperComment->star}}"> </div></span>
                                                </div>
                                                <div class="mt-comment-text"> {{$shopperComment->message}} &nbsp;
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                            @endforeach
                            <!-- END: Comments -->
                                <p><br></p>
                            </div>
                            <div class="tab-pane active" id="traveler_comment" style="height: 1px; overflow: hidden">
                                <!-- BEGIN: Comments -->
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-bubbles font-dark hide"></i>
                                        {{--<h3 style="border-bottom:1px solid #eee; padding-bottom: 10px"--}}
                                            {{--class="caption-subject font-dark  uppercase">{{trans("index.travelerreview")}}</h3>--}}
                                    </div>
                                </div>
                                @if(!$user->rate()->where("type","traveler")->count())
                                    {{--<div class="text-center">{{trans("index.chuacoreviewnao")}}</div>--}}
                                @endif
                                @foreach($user->rate()->where("type","traveler")->get() as $shopperComment)
                                    <div class="mt-comments">
                                        <div class="mt-comment">
                                            <div class="mt-comment-img">
                                                <img src="{{URL::to($shopperComment->user_rate->avatar)}}"></div>
                                            <div class="mt-comment-body">
                                                <div class="mt-comment-info">
                                                    <span class="mt-comment-author">{{$shopperComment->user_rate->first_name}} {{$shopperComment->user_rate->last_name}}</span>
                                                    <span class="mt-comment-date"><div class="rateit"
                                                                                       data-rateit-mode="font"
                                                                                       data-rateit-readonly="true"
                                                                                       data-rateit-value="{{$shopperComment->star}}"> </div></span>
                                                </div>
                                                <div class="mt-comment-text">
                                                    {{$shopperComment->message}} &nbsp;
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                            @endforeach
                            <!-- END: Comments -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/global/plugins/rateit/jquery.rateit.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/pages/scripts/convert-image-to-base64.js')}}
    {{Html::script("https://www.google.com/recaptcha/api.js")}}

    <script type="text/javascript">
        $(".shopperclick").click(function () {
            $("#shopper_comment").show();
            $("#traveler_comment").hide();
        })
        $(".travelerclick").click(function () {
            $("#shopper_comment").hide();
            $("#traveler_comment").show();
            $("#traveler_comment").css("height", "auto");
        })
    </script>
@endsection