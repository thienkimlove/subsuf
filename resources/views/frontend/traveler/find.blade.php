@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/pages/css/search.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}

@endsection
@section('breadcrumb')

@endsection

@section('content')
    <div class=" travel-banner" style="height: 200px;">
        <div class="col-xs-12 col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8">
            <div class="nav-justified" style="margin-top: 20px;" id="tabIndex">
                <div class="tab-content">
                    {{Form::open(['action' => 'Frontend\TravelerController@find', 'method' => 'GET'])}}
                    <h2 align="center" class="font-white">{{trans("index.timkiemcacycmuaho")}}</h2>
                    <br>
                    <div class="input-group input-group-lg hidden-xs hidden-sm" id="select-deliver">
                        {{Form::select("deliver_from",$country,old("deliver_from"),["id"=>"deliverFrom","class"=>"form-control input-lg select2", "placeholder"=>""])}}
                        {{Form::select("deliver_to",$province,old("deliver_to"),["id"=>"deliverFrom","class"=>"form-control input-lg select21", "placeholder"=>""])}}
                        {{--<input type="text" class="form-control" placeholder="Điểm xuất phát (có thể bỏ trống)"--}}
                        {{--style="width: 50%; border-right: none">--}}
                        {{--<input type="text" class="form-control" placeholder="Điểm đến (thành phố)"--}}
                        {{--style="width: 50%">--}}
                        <span class="input-group-btn">
                                <button class="btn red" type="submit">{{trans("index.timkiemyeucau")}}</button>
                            </span>
                    </div>
                    {{Form::close()}}
                    {{Form::open(['action' => 'Frontend\TravelerController@find', 'method' => 'GET'])}}

                    <div class="form-group hidden-lg hidden-md hidden-sm">
                        {{Form::select("deliver_from",$country,"",["id"=>"deliverFrom","class"=>"form-control input-lg select2","placeholder"=>""])}}

                    </div>
                    <div class="form-group hidden-lg hidden-md hiddent-sm">
                        {{Form::select("deliver_to",$province,"",["id"=>"deliverFrom","class"=>"form-control input-lg select21","placeholder"=>""])}}
                    </div>

                    <div class="form-group hidden-lg hidden-md hiddent-sm text-center">
                        <button class="btn red" type="submit" name="start"
                                value="1">{{trans("index.timkiemyeucau")}}</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>


    <div class="container" style="padding-top: 20px">

        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-xs-offset-0">
                @foreach($orderList as $order)
                    <div class=" order-full">
                        <div class="order-thumbnail">
                            <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">
                                <img src="@if(count($order->order_images)) {{URL::to($order->order_images[0]->image)}} @endif"/>
                            </a>

                        </div>
                        <div class="order-title">
                            <div class="order-user">
                                <a href="#">
                                    <img alt="" class="img-circle" src="{{URL::to($order->account["avatar"])}}">
                                    <b>{{$order->account["first_name"]}} {{$order->account["last_name"]}}</b>
                                </a>
                                <span class="order-time">{{reltativeDate(date("d-m-Y H:i:s",strtotime($order->request_time)))}}</span>
                            </div>
                            <div class="order-content">
                                <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">
                                    <img src="@if(count($order->order_images)) {{URL::to($order->order_images[0]->image)}} @endif"/>
                                </a>
                                <h3>
                                    <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">{{$order->name}}</a>
                                </h3>
                                <div class="order-delive" style="border-bottom: 1px solid #eee">
                                <span class="title">
                                    <span class="title">
                                        <span class="btn btn-sm red btn-circle"><i
                                                    class="fa fa-location-arrow"></i> </span> {{trans("index.den")}}
                                        </span>
                                <span class="order-location">{{$order->to_location->name}}</span>
                                </div>
                                <div class="order-delive">
                                    <span class="title"><span class="btn btn-sm red btn-circle"><i
                                                    class="fa fa-map-marker"></i></span> {{trans("index.tu")}} </span>
                                    <span class="order-location">@if($order->from_location) {{$order->from_location->name}} @else
                                            {{trans("index.batkydau")}} @endif</span>
                                </div>
                            </div>
                            <div class="order-off">
                                @if($order->offers->count()==0)
                                   {{trans("index.tiencong")}} <span class="font-red ">{{$order->traveler_reward}}$</span>
                                @elseif($order->offers->count()==1)
                                    <span class="font-red ">{{$order->offers->count()}}</span> {{trans("index.denghi")}}
                                    , {{trans("index.tiencong")}}
                                    <span class="font-red ">
                                        ${{$order->offers[0]->shipping_fee+$order->offers[0]->others_fee+$order->offers[0]->tax}}

                                    </span>
                                @else
                                    <?php
                                    $minOffer = 0;
                                    $maxOffer = 0;
                                    foreach ($order->offers as $offer) {
                                        $offerVal = $offer->shipping_fee + $offer->others_fee + $offer->tax;
                                        if ($minOffer == 0 || $minOffer > $offerVal) $minOffer = $offerVal;
                                        if ($maxOffer == 0 || $maxOffer < $offerVal) $maxOffer = $offerVal;
                                    }
                                    ?>
                                    <span class="font-red ">{{$order->offers->count()}}</span> {{trans("index.denghi_n")}}
                                    , {{trans("index.tiencong")}}
                                    {{trans("index.tu")}}
                                    <span class="font-red ">
                                        {{$minOffer}}$
                                    </span>
                                    {{trans("index.den")}}
                                    <span class="font-red ">
                                        {{$maxOffer}}$
                                    </span>
                                @endif

                                <div class="action">
                                    <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">
                                        {{trans("index.nhanmuaho")}} <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--<div class=" order-full">--}}
                {{--<div class="order-thumbnail">--}}
                {{--<a href="javascript:;">--}}
                {{--<img src="/upload/admin/brand/cover_161024083104.jpeg"/>--}}
                {{--</a>--}}

                {{--</div>--}}
                {{--<div class="order-title">--}}
                {{--<div class="order-user">--}}
                {{--<a href="">--}}
                {{--<img alt="" class="img-circle" src="/assets/layouts/layout3/img/avatar9.jpg">--}}
                {{--<b>Nick</b>--}}
                {{--</a>--}}
                {{--requested--}}

                {{--<span class="order-time">5 phút trước</span>--}}
                {{--</div>--}}
                {{--<div class="order-content">--}}
                {{--<h3>--}}
                {{--<a href="javascript:;">Sennheiser Momentum 2.0 On Ear Wireless With Active Noise--}}
                {{--Cancellation</a>--}}
                {{--</h3>--}}
                {{--<div class="order-delive" style="border-bottom: 1px solid #eee">--}}
                {{--<span class="title">--}}
                {{--<span class="title">--}}
                {{--<span class="btn btn-sm red btn-circle"><i class="fa fa-map-marker"></i> </span> Deliver to--}}
                {{--</span>--}}
                {{--<span class="order-location">Ho Chi Minh City</span>--}}
                {{--</div>--}}
                {{--<div class="order-delive">--}}
                {{--<span class="title"><span class="btn btn-sm red btn-circle"><i class="fa fa-location-arrow"></i></span>  Deliver to</span>--}}
                {{--<span class="order-location">Anywhere</span>--}}
                {{--</div>--}}


                {{--</div>--}}
                {{--<div class="order-off">--}}
                {{--1 offers from <span class="font-red ">11$</span>--}}

                {{--<div class="action">--}}
                {{--<a > Make offer <i class="fa fa-arrow-right"></i></a>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

@endsection

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}
    <script type="text/javascript">
        var ComponentsSelect2 = function () {

            var handleDemo = function () {

                // Set the "bootstrap" theme as the default theme for all Select2
                // widgets.
                //
                // @see https://github.com/select2/select2/issues/2927
                $.fn.select2.defaults.set("theme", "bootstrap");

                var placeholder = "Select a State";

                $(".select2, .select2-multiple").select2({
                    placeholder: "{!! trans("index.diemxuatphat_select") !!}",
                    width: null
                });
                $(".select21").select2({
                    placeholder: "{!! trans("index.diemden_select") !!}",
                    width: null
                });


                $(".select2-allow-clear").select2({
                    allowClear: true,
                    placeholder: placeholder,
                    width: null
                });

                // @see https://select2.github.io/examples.html#data-ajax
                function formatRepo(repo) {
                    if (repo.loading) return repo.text;

                    var markup = "<div class='select2-result-repository clearfix'>" +
                            "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
                            "<div class='select2-result-repository__meta'>" +
                            "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

                    if (repo.description) {
                        markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
                    }

                    markup += "<div class='select2-result-repository__statistics'>" +
                            "<div class='select2-result-repository__forks'><span class='glyphicon glyphicon-flash'></span> " + repo.forks_count + " Forks</div>" +
                            "<div class='select2-result-repository__stargazers'><span class='glyphicon glyphicon-star'></span> " + repo.stargazers_count + " Stars</div>" +
                            "<div class='select2-result-repository__watchers'><span class='glyphicon glyphicon-eye-open'></span> " + repo.watchers_count + " Watchers</div>" +
                            "</div>" +
                            "</div></div>";

                    return markup;
                }

                function formatRepoSelection(repo) {
                    return repo.full_name || repo.text;
                }

                $(".js-data-example-ajax").select2({
                    width: "off",
                    ajax: {
                        url: "https://api.github.com/search/repositories",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term, // search term
                                page: params.page
                            };
                        },
                        processResults: function (data, page) {
                            // parse the results into the format expected by Select2.
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data
                            return {
                                results: data.items
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1,
                    templateResult: formatRepo,
                    templateSelection: formatRepoSelection
                });

                $("button[data-select2-open]").click(function () {
                    $("#" + $(this).data("select2-open")).select2("open");
                });

                $(":checkbox").on("click", function () {
                    $(this).parent().nextAll("select").prop("disabled", !this.checked);
                });

                // copy Bootstrap validation states to Select2 dropdown
                //
                // add .has-waring, .has-error, .has-succes to the Select2 dropdown
                // (was #select2-drop in Select2 v3.x, in Select2 v4 can be selected via
                // body > .select2-container) if _any_ of the opened Select2's parents
                // has one of these forementioned classes (YUCK! ;-))
                $(".select2, .select2-multiple, .select2-allow-clear, .js-data-example-ajax").on("select2:open", function () {
                    if ($(this).parents("[class*='has-']").length) {
                        var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);

                        for (var i = 0; i < classNames.length; ++i) {
                            if (classNames[i].match("has-")) {
                                $("body > .select2-container").addClass(classNames[i]);
                            }
                        }
                    }
                });

                $(".js-btn-set-scaling-classes").on("click", function () {
                    $("#select2-multiple-input-sm, #select2-single-input-sm").next(".select2-container--bootstrap").addClass("input-sm");
                    $("#select2-multiple-input-lg, #select2-single-input-lg").next(".select2-container--bootstrap").addClass("input-lg");
                    $(this).removeClass("btn-primary btn-outline").prop("disabled", true);
                });
            };

            return {
                //main function to initiate the module
                init: function () {
                    handleDemo();
                }
            };

        }();

        if (App.isAngularJsApp() === false) {
            jQuery(document).ready(function () {
                ComponentsSelect2.init();
            });
        }

    </script>
@endsection