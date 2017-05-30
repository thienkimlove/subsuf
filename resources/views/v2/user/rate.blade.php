@extends('v2.template')

@section('style')

    <link rel="stylesheet" href="/v2/css/profile.css">
    <link rel="stylesheet" href="/v2/css/component.css">
    <link rel="stylesheet" href="/v2/css/custom.css">

@endsection
@section('content')
    <div class="wrap_container wrap_quytrinhnhanmuaho">
    <div class="container white">
        <div class="row margin-top-40">
            <div class="col-lg-8 col-lg-offset-2">
                <h3 class="text-center">
                    {{trans("index.review") }} @if($rate=="shopper") {{trans("index.shopper")}} @else {{trans("index.traveler")}} @endif
                </h3>
                <div class=" bg-grey-steel" style=" padding: 10px">

                    <div style="width:300px; margin: 20px auto;">
                        <div class="text-center">
                            <img class="img-circle" src="{{URL::to($user->avatar)}}"
                                 style="width: 50px; height: 50px;">
                            <br>
                            <p class="bold">
                                {{$user->first_name}} {{$user->last_name}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="portlet light">

                    <div class="portlet-body form">
                        {{Form::open(['action' => ['Frontend\UserController@userRateUpdate',$transaction->transaction_id]])}}
                        <div class="row">
                            @include("frontend.message")
                            <div class="col-lg-12 starrate">
                                <div class="form-group">
                                    <label>{{trans("index.diemdanhgia")}}: </label>
                                    <input name="star" type="text" value="5" id="starRate">
                                    <div class="rateit" data-rateit-resetable="false"
                                         data-rateit-backingfld="#starRate"
                                         data-rateit-value="5"
                                         data-rateit-mode="font">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="comment" placeholder="Comment" class="form-control"></textarea>
                                </div>

                                <div class="form-group text-center">
                                    <a class="btn btn-outline btn-default "
                                       href="{{URL::action("Frontend\ShopperController@orderDetail",$transaction->offer->order_order_id)}}">
                                        {{trans("index.quaylai")}}
                                    </a>
                                    <button type="submit" value="" class="btn red">
                                        <i class="fa fa-star"></i> {{trans("index.review")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection

@section('frontend_script')
    {{Html::script('assets/global/plugins/rateit/jquery.rateit.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/pages/scripts/convert-image-to-base64.js')}}

    <script type="text/javascript">
        $(".shopperclick").click(function () {
            $("#shopper_comment").show();
            $("#traveler_comment").hide();
        })
        $(".travelerclick").click(function () {
            $("#shopper_comment").hide();
            $("#traveler_comment").show();
        })
    </script>
@endsection