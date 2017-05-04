@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}
    {{Html::style('assets/global/plugins/owlcarousel/assets/owl.carousel.css')}}


    <style>
        .about-header h2, .stories-header h2 {
            letter-spacing: 1px;
            text-transform: none;
        }

        video {
            width: 100% !important;
            height: auto !important;
        }

        .select2-selection {
            max-height: 44px;

        }

        .vertical-alignment-helper {
            display: table;
            height: 100%;
            width: 100%;
            pointer-events: none;
        }

        .vertical-align-center {
            /* To center vertically */
            display: table-cell;
            vertical-align: middle;
            pointer-events: none;
        }

        .modal-content {
            /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
            width: inherit;
            height: inherit;
            /* To center horizontally */
            margin: 0 auto;
            pointer-events: all;
        }
    </style>
@endsection
@section('breadcrumb')

@endsection

@section('content')
    <div class=" about-header"
         style="background-image:url('/images/index_fullsize_distr.jpg'); height: 600px; background-size: cover">
        <div class="col-xs-12 col-md-offset-1 col-md-10 col-lg-offset-2 col-lg-8" id="indexTab"
        >
            <div class="tabbable-custom nav-justified" id="tabIndex">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1_1_1" data-toggle="tab"
                           onclick="showHiw('hiwDathang')"> {{trans("index.dathang")}} </a>
                    </li>
                    <li>
                        <a href="#tab_1_1_2" data-toggle="tab"
                           onclick="showHiw('hiwNhanhang')"> {{trans("index.nhanmuaho")}}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1_1_1">
                        {{Form::open(['action' => 'Frontend\ShopperController@order', 'method' => 'GET'])}}

                        <h2>
                            {{trans("index.shopper_slogan")}}
                        </h2>
                        <p></p>
                        <div class="text-xs-center hidden-xs "><p class="font-size-lg m-b-2 p-x-1">
                                <span>{{trans("index.shopper_slogan2")}}
                                </span>
                        </div>

                        <div class="input-group input-group-lg hidden-xs">
                            <input type="text" name="url" class="form-control"
                                   placeholder="{{trans('index.nhaplinksp')}}">
                            <span class="input-group-btn">
                                <button class="btn red" type="submit" name="start"
                                        value="1">{{trans("index.batdaudathang")}}</button>
                            </span>
                        </div>
                        {{Form::close()}}
                        {{Form::open(['action' => 'Frontend\ShopperController@order', 'method' => 'GET'])}}

                        <div class="form-group hidden-lg hidden-md hidden-sm">
                            <input type="text" name="url" class="form-control"
                                   placeholder="{{trans('index.nhaplinksp')}}">
                        </div>

                        <div class="form-group hidden-lg hidden-md hiddent-sm">
                            <button class="btn red" type="submit" name="start"
                                    value="1">{{trans("index.batdaudathang")}}</button>
                        </div>
                        {{Form::close()}}


                    </div>
                    <div class="tab-pane form" id="tab_1_1_2">
                        {{Form::open(['action' => 'Frontend\TravelerController@find', 'method' => 'GET'])}}

                        <h2 style="">
                            {{trans("index.traveler_slogan")}}
                        </h2>
                        <br>
                        <div class="text-xs-center hidden-xs"><p class="font-size-lg m-b-2 p-x-1">
                                <span>{{trans("index.traveler_slogan2")}}
                                </span>
                        </div>
                        <div class="form-group hidden-xs">
                            <div class="input-group input-group-lg" id="select-deliver">
                                {{Form::select("deliver_from",$country,"",["id"=>"deliverFrom","class"=>"form-control input-lg select2","placeholder"=>""])}}
                                {{Form::select("deliver_to",$province,"",["id"=>"deliverFrom","class"=>"form-control input-lg select21","placeholder"=>""])}}

                                <span class="input-group-btn">
                                <button class="btn red" type="submit">{{trans("index.timkiemdonhang")}}</button>
                            </span>
                            </div>
                        </div>
                        {{Form::close()}}

                        {{Form::open(['action' => 'Frontend\TravelerController@find', 'method' => 'GET'])}}

                        <div class="form-group hidden-lg hidden-md hiddent-sm">
                            {{Form::select("deliver_from",$country,"",["id"=>"deliverFrom","class"=>"form-control input-lg select2","placeholder"=>""])}}

                        </div>
                        <div class="form-group hidden-lg hidden-md hiddent-sm">
                            {{Form::select("deliver_to",$province,"",["id"=>"deliverFrom","class"=>"form-control input-lg select21","placeholder"=>""])}}

                        </div>

                        <div class="form-group hidden-lg hidden-md hiddent-sm">
                            <button class="btn red" type="submit" name="start"
                                    value="1">{{trans("index.timkiemdonhang")}}</button>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>

        </div>
        <div class="how-it-work" id="hiwDathang">
            <a href="#dat-hang">{{trans("index.cachdathang")}}</a> &nbsp; <a style="text-decoration: none;">|</a> &nbsp;
            <a href="#nhan-dat-hang">{{trans("index.cachnhanmuaho")}}</a>

        </div>
        <div class="how-it-work" id="hiwNhanhang" style="display: none">
        </div>
    </div>
    <div class="about-links-cont" data-auto-height="true">
        <div class="container">
            <div class="row margin-bottom-40 text-center" data-auto-height="true">
                <div class="col-xs-12">
                    <h1 style="margin-top: 40px; margin-bottom: 10px; font-weight: 400">
                        <small style="margin-top: 5px; display: inline-block"><i class="fa fa-quote-left font-red"></i>
                        </small>
                        {{trans("index.muabatcuthugi")}}
                        <small><i class="fa fa-quote-right  font-red"></i></small>
                    </h1>
                </div>
            </div>
            <div class="  margin-bottom-40">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-sm-12 why-chose-us">
                            <img class="image-left" src="/upload/1.png">
                            <div class="text-content">
                                <h4>{{trans("index.chiphivanchuyenthap")}}</h4>
                                <span class="font-blue-oleo">{{trans("index.chiphivanchuyenthap_detail")}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 why-chose-us">
                            <img class="image-left" src="/upload/8.png">
                            <div class="text-content">
                                <h4>{{trans("index.nguongocminhbach")}}</h4>
                                <span class="font-blue-oleo">
                                    {{trans("index.nguongocminhbach_detail")}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 why-chose-us">
                            <img class="image-left" src="/upload/2.png">
                            <div class="text-content">
                                <h4>{{trans("index.boihoandaydu")}}</h4>
                                <span class="font-blue-oleo">
                                {{trans("index.boihoandaydu_detail")}}.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12" id="video-img-content"
                     style="">
                    <a data-toggle="modal" href="#updateInfoModal" id="intro_video"
                       data-target="#updateInfoModal"
                       data-video="{{trans('index.youtube')}}">
                        <img src="/images/imac.jpg" height="100%" class="image-video">
                    </a>
                    <div id="updateInfoModal" class="modal fade" tabindex="-1"
                         data-keyboard="false">
                        <div class="vertical-alignment-helper">
                            <div class="modal-dialog vertical-align-center">
                                <div class="modal-content"
                                     style="background: transparent; box-shadow: none; border: none">
                                    <div class="modal-body">
                                        <iframe id="videocontent" width="720" height="480" style="margin-top: 10px;"
                                                src="" allowfullscreen="allowfullscreen" frameborder="0">
                                        </iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix" style="padding: 20px"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="about-links-cont" data-auto-height="true" id="quytrinh"
         style=" background: #fdc4bd url('/images/quytrinhdathang.jpg') no-repeat; background-size: 100%">
        <div class=" margin-bottom-40 stories-header" data-auto-height="true" style="position: relative;">
            <div id="dat-hang" style="padding: 1px;"></div>
            <div class="col-md-12">
                <h1 class="" style="padding: 20px"> {{trans("index.quytrinhdathang")}}</h1>
            </div>
        </div>
        <div class="container">
        </div>
        <div class=" margin-bottom-20" id="quytrinhdathang">
            <div class="col-xs-12 col-md-4 m-xs-b-2 m-md-b-0">
                <div class="portlet light">
                    <div class="step-content">
                        <div class="card-icon">
                            {{--<img style="max-width: 175px" src="/assets/subsuf_img/shop_1.png">--}}
                            <img style=""
                                 src="/upload/8.png">
                        </div>
                        <div class="card-title">
                            <span> {{trans("index.taoyeucau")}}</span>
                        </div>
                        <div class="card-desc">
                        <span>{{trans("index.taoyeucau_detail")}}<span
                                    class="font-white">.</span> </span>
                        </div>
                    </div>
                    <div class="step-number"></div>
                </div>
            </div>

            <div class="col-xs-12 col-md-4 m-xs-b-2 m-md-b-0">
                <div class="portlet light">
                    <div class="step-content">
                        <div class="card-icon">
                            <img style=" "
                                 src="/upload/3.png">
                        </div>
                        <div class="card-title">
                            <span> {{trans("index.chondenghiphuhop")}} </span>
                        </div>
                        <div class="card-desc">
                        <span>{{trans("index.chondenghiphuhop_detail")}}
                        </span>
                        </div>
                    </div>
                    <div class="step-number"></div>
                </div>
            </div>

            <div class="col-xs-12 col-md-4 m-xs-b-2 m-md-b-0">
                <div class="portlet light">
                    <div class="step-content">
                        <div class="card-icon">
                            <img style=""
                                 src="/upload/9.png">
                        </div>
                        <div class="card-title">
                            <span> {{trans("index.gapnguoimuahodenhanhang")}}</span>
                        </div>
                        <div class="card-desc">
                        <span>{{trans("index.gapnguoimuahodenhanhang_detail")}}
                            <span class="font-white">.</span>
                        </span>
                        </div>
                    </div>
                    <div class="step-number"></div>
                </div>
            </div>
        </div>

        <div class="text-center clearfix ">
            <a href="{{URL::action("Frontend\ShopperController@order")}}"
               class="btn btn-lg btn-danger">{{trans("index.batdaudathang")}}</a>
            <br>
            <br>
        </div>
    </div>

    <div class=" stories-header" data-auto-height="true" id="kiemthemthunhap"
         style="padding-top: 40px; padding-bottom: 40px; position: relative; background:#fdc4bd url('/images/kiemthemthunhap.jpg') no-repeat; background-position: bottom; background-size: 100%">
        <div id="nhan-dat-hang" class="" style="padding: 50px; position: absolute; top: -150px; "></div>
        <div class="margin-bottom-40 stories-header" data-auto-height="true">
            <div class="col-xs-12">
                <h1 style="padding: 20px; padding-top: 0; margin-top: 0;">
                    {{trans("index.kiemthemthunhapvoichuyenbay")}}
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="portlet-body">
                <div class="mt-element-step">

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4 m-xs-b-2 m-md-b-0">
            <div class="portlet light">
                <div class="card-icon">
                    <img style="max-height: 105px; margin-top: 20px; border: 2px solid #ccc; border-radius:50% !important; padding: 15px "
                         src="/upload/3.png">
                </div>
                <div class="card-title">
                    <br>

                    <span>{{trans("index.timycdathang")}}  </span>
                </div>
                <div class="card-desc">
                    <span>{{trans("index.timycdathang_detail")}} </span>
                </div>

            </div>
        </div>

        <div class="col-xs-12 col-md-4 m-xs-b-2 m-md-b-0">
            <div class="portlet light">
                <div class="card-icon">
                    <img style="max-height: 105px; margin-top: 20px; border: 2px solid #ccc; border-radius:50% !important; padding: 15px "
                         src="/upload/6.png">
                </div>
                <div class="card-title">
                    <br>
                    <span>{{trans("index.denghimuaho")}}  </span>
                </div>
                <div class="card-desc">
                    <span>{{trans("index.denghimuaho_detail")}} </span>
                </div>

            </div>
        </div>

        <div class="col-xs-12 col-md-4 m-xs-b-2 m-md-b-0">
            <div class="portlet light">
                <div class="card-icon">
                    <img style="max-height: 105px; margin-top: 20px; border: 2px solid #ccc; border-radius:50% !important; padding: 15px "
                         src="/upload/7.png">
                </div>
                <div class="card-title">
                    <br>

                    <span>{{trans("index.vanchuyenvanhantien")}}  </span>
                </div>
                <div class="card-desc">
                    <span>{{trans("index.vanchuyenvanhantien_detail")}} </span>
                </div>
            </div>
        </div>
        <div class="text-center  margin-bottom-20">
            <a href="{{URL::action("Frontend\TravelerController@index")}}" class="btn btn-lg btn-danger">
                {{trans("index.timkiemdonhang")}} </a>

        </div>
    </div>



    <div class="container">
        <div class="row margin-bottom-40 margin-top-20 stories-header" data-auto-height="true">
            <div class="col-xs-12">
                <h1>{{trans("index.nhungdonhanghoanthanhganday")}}</h1>
            </div>
        </div>
        <div class="row blog-page blog-content-1 olwcarouselIndex">
            @foreach($listOrderFinish as $key=>$transaction)
                <?php
                $offer = $transaction->offer; if (!$offer) continue; ?>
                <?php $order = $offer->order ?>
                <div>
                    <div class=" white">
                        <div class="row margin-top-40">
                            <div class="col-lg-12">
                                <div class="image-order">
                                    <img src="{{$order->order_images[0]->image}}" style="width: 100%; height: 360px">
                                </div>
                                <div class="bg-white"
                                     style="border-top:1px solid #eee;border-bottom:1px solid #eee; height: 160px; padding: 10px">
                                    <div style="width:300px;margin: 20px auto;">
                                        <div class="order-finish-box" class="text-center" style="width: 120px;">
                                            <a class="link-img"
                                               href="{{URL::action("Frontend\UserController@userRateDetail",$offer->account->account_id)}}">
                                                <img class="img-circle"
                                                     src="{{URL::to($offer->account->avatar)}}"
                                                     style="width: 50px; height: 50px; margin-bottom: 10px">
                                            </a>
                                            <br>
                                            <a href="" class="bold" style="font-size: 12px; ">
                                                {{$offer->account->first_name}} {{$offer->account->last_name}}
                                            </a>
                                            <p style="margin-top: 5px">
                                                {{$offer->from_location["name"]}}
                                            </p>
                                        </div>
                                        <div class="order-finish-box order-finish-box-icon" class="text-center"
                                             style="width: 60px;">
                                            <br>
                                            <i class="fa fa-2x fa-plane"></i>
                                            <br>
                                            {{date("d-m-Y",strtotime($offer->deliver_date))}}
                                        </div>
                                        <div class="order-finish-box" class="text-center" style="width: 120px;">
                                            <a class="link-img"
                                               href="{{URL::action("Frontend\UserController@userRateDetail",$order->account->account_id)}}">

                                                <img class="img-circle" src="{{URL::to($order->account->avatar)}}"
                                                     style="width: 50px; height: 50px;  margin-bottom: 10px">
                                            </a>
                                            <br>
                                            <a href="" class="bold" style="font-size: 12px; ">
                                                {{$order->account->first_name}} {{$order->account->last_name}}
                                            </a>
                                            <p style="margin-top: 5px">
                                                {{$order->to_location["name"]}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet light">

                                    <div class="portlet-body form">

                                        <div class="row">
                                            <div class="col-lg-12 margin-top-10">

                                                <div class="col-lg-12" style="border: none">
                                                    <h4 class="invoice-title text-center ">{{trans("index.tiencongnhanduoc")}}
                                                        <span class="content-right font-red">
                                                <b style="font-size: 20px">
                                                    ${{$offer->others_fee+$offer->shipping_fee+$offer->tax}}
                                                </b>
                                            </span>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endsection

@section('script')
    <style>
        .select2-container--bootstrap .select2-selection--multiple .select2-search--inline .select2-search__field {
            min-width: 300px;
        }
    </style>
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}
    {{Html::script('assets/global/plugins/owlcarousel/owl.carousel.min.js')}}


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
                    placeholder: "{!!  trans("index.diemxuatphat_select") !!}",
                    width: null
                });
                $(".select21").select2({
                    placeholder: "{!!  trans("index.diemden_select")!!}",
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
        function showHiw(id) {
//            $(".how-it-work").hide();
//            $("#"+id).show();
        }

        $("#intro_video").click(function () {
            var theModal = $(this).data("target"),
                    videoSRC = $(this).attr("data-video"),
                    videoSRCauto = videoSRC + "?autoplay=1";
            $(theModal + ' iframe').attr('src', videoSRCauto);
            $(theModal + ' button.close').click(function () {
                $(theModal + ' iframe').attr('src', videoSRC);
            });

            var width = $(window).width() - 30;
            if (parseInt(width) < 720) {
                console.log(width);
                $(theModal + ' iframe').attr('width', width);
                $(theModal + ' iframe').attr('height', width * 2 / 3);
            }
        });

        $("#updateInfoModal").on('hidden.bs.modal', function (e) {
            $("#updateInfoModal").find("iframe").attr("src", "");
        });
    </script>
    <script type="text/javascript">
        $(".olwcarouselIndex").owlCarousel({
            loop: true,
            nav: false,
            margin: 30,
            responsiveClass: true,
            navText: ['<i class="fa fa-caret-left"></i>', '<i class="fa fa-caret-right"></i>'],
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: false
                },
                1000: {
                    items: 3,
                    nav: true,
                    loop: false
                }
            }
        })
    </script>
    <style>
        .owl-carousel .owl-item img {
            display: inline-block;
        }

        .owl-prev {
            position: absolute;
            bottom: 50%;
            left: -40px;
            color: #c0d2ea;
            font-size: 50px;
        }

        .owl-next {
            position: absolute;
            bottom: 50%;
            right: -40px;
            color: #c0d2ea;
            font-size: 50px;

        }

        .owl-prev:hover {
            color: #e7505a !important;;
            left: -42px;

        }

        .owl-next:hover {
            color: #e7505a !important;;
            right: -42px;
        }

    </style>
@endsection