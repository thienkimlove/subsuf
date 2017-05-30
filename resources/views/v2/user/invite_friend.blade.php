@extends('v2.template')
@section('style')
    <link rel="stylesheet" href="/v2/css/profile.css">
    <link rel="stylesheet" href="/v2/css/component.css">
    <link rel="stylesheet" href="/v2/css/custom.css">
@endsection

@section('content')
    @include("frontend.message")
    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=330048447024205";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <div class="wrap_container wrap_quytrinhnhanmuaho">
    <div class="container margin-top-40">
        <div class="col-md-12">
            <div class="profile-sidebar">
                @include("frontend.user.profile_menu")
            </div>
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">

                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <p class="text-center">
                                            <img src="/images/money-box.png">
                                        </p>
                                        <h4 class="text-center">
                                            {{trans("index.moibanbe_detail")}}

                                        </h4>
                                        <hr>
                                        <div class="margin-top-20">
                                            <div class="form">
                                                {{--<div class="form-group">--}}
                                                {{--<label>--}}
                                                {{--{{trans("index.moibanbequaemail")}}--}}
                                                {{--</label>--}}
                                                {{--<div class="input-group">--}}

                                                {{--<input class="form-control" type="text"--}}
                                                {{--name="email"--}}
                                                {{--placeholder="friend1@example.com, friend2@example.com, friend2@example.com">--}}

                                                {{--<span class="input-group-btn">--}}
                                                {{--<button id="genpassword" class="btn btn-success"--}}
                                                {{--type="button">--}}
                                                {{--<i class="fa fa-envelope fa-fw"></i> {{trans("index.guiemail")}}--}}
                                                {{--</button>--}}
                                                {{--</span>--}}
                                                {{--</div>--}}
                                                {{--<hr>--}}
                                                {{--</div>--}}
                                                <div class="form-group">
                                                    <label>
                                                        {{trans("index.moibanbequamagioithieu")}}
                                                    </label>
                                                    <div class="input-group">
                                                        <input id="shareCode" class="form-control"
                                                               type="text"
                                                               value="{{$user->share_code}}"
                                                               placeholder="" readonly
                                                               style="background: #fff">
                                                        <span class="input-group-btn">
                                                                <button class="btn btn-success"
                                                                        type="button"
                                                                        data-clipboard-target="#shareCode">
                                                                    Copy
                                                                </button>
                                                            </span>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                        <div class="form -group">
                                            <label>
                                                {{trans("index.moibanbequafacebook")}}
                                            </label>
                                            <div class="input-group ">
                                                {{--<a class="btn btn-block blue-steel hidden"--}}
                                                {{--target="_blank"--}}
                                                {{--href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">--}}
                                                {{--<span class="fa fa-facebook"></span>--}}
                                                {{--&nbsp; {{trans("index.moibanbequafacebook")}}--}}
                                                {{--</a>--}}
                                            </div>
                                            <div class="fb-share-button"
                                                 data-href="http://subsuf.com/register?sharecode={{$user->share_code}}"
                                                 data-layout="button" data-size="large"
                                                 data-mobile-iframe="true">
                                                <a class="fb-xfbml-parse-ignore" style="width: 100%"
                                                   target="_blank"
                                                   href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">
                                                    Chia sẻ</a>
                                            </div>
                                            <hr/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center  margin-top-10 margin-bottom-20">
                                    <div class="col-md-4 ">
                                        <i class="fa fa-share fa-2x"></i>
                                        <br>
                                        <br>
                                        <p>Share your invite link with friends.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="fa fa-usd fa-2x"></i>
                                        <br><br>
                                        <p>Earn $10 after your friend receives their first order.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="fa fa-usd fa-2x"></i>
                                        <br><br>
                                        <p>$50 after they deliver one.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('frontend_script')
    {{Html::script('assets/global/plugins/clipboard/clipboard.min.js')}}

    <script>
        new Clipboard('.btn');
    </script>
@endsection