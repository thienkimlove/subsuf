@extends('v2.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/pages/css/search.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}
    {{Html::style('assets/global/css/components.min.css')}}
    {{Html::style('assets/layouts/layout3/css/layout.css')}}
    {{Html::style('assets/layouts/layout3/css/themes/default.min.css')}}
    {{Html::style('assets/layouts/layout3/css/custom.css')}}
    {{Html::favicon('/assets/subsuf_img/logo.png')}}
@endsection
@section('content')
    <div class="wrap_container wrap_quytrinhnhanmuaho">

    <div class="container white">
        <div class="row margin-top-40">
            @include("frontend.message")
            <div class="portlet light">
                <div class="portlet-body form">

                    <div class="row">
                        {!! Form::open(['action' => ['Frontend\ShopperController@doEditOrder',$order->order_id], 'method' => 'POST','id'=>'addPlanDetail', 'files' => true,"data-toggle"=>"validator"]) !!}
                        <div class="col-lg-12 margin-top-10">

                            <br>
                            <div id="imageAdd">
                                <label>{{trans("index.anhsanphamchon1")}}</label>
                                <div class="image-block">
                                    @if($order->order_images)
                                        @foreach($order->order_images as $key=>$image)
                                            <?php if ($key >= 5) {
                                                break;
                                            }  ?>
                                            <div class="fileinput-new images-input">
                                                <div class="close-image" onclick="removeImg(this)"><i
                                                            class="glyphicon glyphicon-remove"></i></div>
                                                <img class="product-file-1"
                                                     src="{{URL::to($image->image)}}" alt="">
                                                <input type="hidden" name="images-link[]"
                                                       value="{{$image->order_image_id}}">
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="fileinput-new images-input"
                                         @if(isset($order["images"])) @if(count($order["images"])>=5)
                                         style="display: none" @endif @endif>
                                        <img id="addImageBtn" class="product-file-1"
                                             src="/images/add-image.jpg" alt=""
                                             data-count="@if(isset($order["images"])) {{(count($order["images"])<5) ? count($order["images"]):5}} @else 0 @endif"
                                             onclick="setImageFile(this)"
                                        >
                                        <input type="file" name="images[]" class="hidden" class="product-file-1"
                                               onchange="updateFileImage(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix margin-bottom-10"></div>
                            <br>
                            <div class="form-group">
                                <label>{{trans("index.tensanpham")}}</label>
                                <textarea name="name" class="form-control" placeholder="{{trans("index.tensanpham")}}"
                                          required
                                          maxlength="200">{{isset($order["name"])?$order["name"]:""}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.motasanpham")}}</label>
                                <textarea class="form-control" name="description" rows="5"
                                          placeholder="{{trans("index.mausackichco")}}" required
                                          maxlength="200">{{isset($order["description"])?$order["description"]:""}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.linksp")}}</label>
                                <input name="link" class="form-control" placeholder="{{trans("index.linksp")}}"
                                       maxlength="255"
                                       value="{{isset($order["link"])?$order["link"]:""}}"/>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.giasanpham")}}($)</label>
                                <input class="form-control spinner" name="price" type="number" step=any min="1"
                                       data-error="{{trans("index.price_min")}}"
                                       value="{{isset($order["price"])?$order["price"]:""}}" required="">
                                <div class="help-block with-errors"></div>
                                <p style="margin-top: 15px">
                                    <small>
                                        <i>{!!  trans("index.neugiasanphankophaiusd")!!}</i>
                                        {{--<a class="font-blue"--}}
                                        {{--data-toggle="modal" href="#basic">--}}
                                        {{--<i class="fa fa-question-circle"></i> {{trans("index.tigiaquydoi")}}--}}
                                        {{--</a>--}}
                                    </small>
                                </p>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.soluong")}}</label>
                                <br>
                                <div class="btn-group" id="quantityItem">
                                    <button type="button" class="btn btn-outline red bold" id="quantityMinus"
                                            style="min-width: 34px">-
                                    </button>

                                    <input type="text" name="quantity" id="quantity" class="btn  border-red"
                                           value="{{isset($order["quantity"])?$order["quantity"]:"1"}}" min="1"
                                           style="width: 40px">
                                    <button type="button" class="btn btn-outline red bold" id="quantityPlus">+</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.den")}} </label>
                                {{Form::select("deliver_to",$province,($order["deliver_to"])?$order["deliver_to"]:"",["id"=>"deliverTo","class"=>"form-control select21","required"=>"required"])}}
                            </div>
                            <div class="form-group" id="deliverFrom"
                                 @if(!isset($order["deliver_to"]))style="display: block" @endif>
                                <label>{{trans("index.tu")}} </label>
                            {{Form::select("deliver_from",$country,($order["deliver_from"])?$order["deliver_from"]:"",["class"=>"form-control select2"])}}
                            <!-- /input-group -->
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>{{trans("index.ngaygiaohang")}} </label>
                                <input class="form-control datepicker" name="deliver_date" type="text"
                                       style="padding: 6px 12px;"
                                       value="{{($order["deliver_date"])?date("d-m-Y",strtotime($order["deliver_date"])):""}}">
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.nhaptienchonguoimuaho")}}
                                </label>
                                <p class="text" style="color: #999">
                                    {{trans("index.tiencongbaogomthueneuco")}}
                                </p>
                                {{--<p>{{trans("index.goiytiencong")}}:</p>--}}
                                {{--<div id="rewardSelect">--}}
                                {{--<button type="button" data-reward="{{$reward[0]}}"--}}
                                {{--class="reward btn btn-circle-big red @if(!($order["traveler_reward"]==$reward[0])) btn-outline @endif">--}}
                                {{--<b>${{$reward[0]}}</b>--}}
                                {{--<br>--}}
                                {{--<small>5%</small>--}}
                                {{--</button>--}}
                                {{--<button type="button" data-reward="{{$reward[1]}}"--}}
                                {{--class="reward btn btn-circle-big red @if(!($order["traveler_reward"]==$reward[1])) btn-outline @endif">--}}
                                {{--<b>${{$reward[1]}}</b>--}}
                                {{--<br>--}}
                                {{--<small>10%</small>--}}
                                {{--</button>--}}
                                {{--<button type="button" data-reward="{{$reward[2]}}"--}}
                                {{--class="reward btn btn-circle-big red @if(!($order["traveler_reward"]==$reward[2])) btn-outline @endif">--}}
                                {{--<b>${{$reward[2]}}</b>--}}
                                {{--<br>--}}
                                {{--<small>15%</small>--}}
                                {{--</button>--}}
                                {{--</div>--}}
                            </div>

                            <div class="form-group">
                                {{--                                <label> {{trans("index.hoactunhaptiencong")}} :</label>--}}
                                <div class="input-icon">
                                    <i class="fa fa-usd font-red"></i>
                                    <input type="number" name="input-reward" class="form-control input-reward" min="5"
                                           step="any" data-error="{{trans("index.reward_min")}}"
                                           placeholder="" value="{{$order["traveler_reward"]}}" required>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-actions text-right">
                                <button type="submit" name="isorder" value="1" class="btn btn-circle green btn-lg">
                                    {{trans("index.luulai")}} <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{trans("index.tensanpham")}}  </h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striper table-bordered">
                        <tr>
                            <th>
                                {{trans("index.loaitien")}}
                            </th>
                            <th>{{trans("index.quydoisang")}} </th>
                            <th>{{trans("index.tigia")}} </th>
                        </tr>
                        @foreach($exchangeArr as $item)
                            <tr>
                                <td>{{$item->from_currency}}</td>
                                <td>{{$item->to_currency}}</td>
                                <td>{{number_format($item->money)}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('frontend_script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/pages/scripts/convert-image-to-base64.js')}}
    {{Html::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
    {{Html::script('assets/pages/scripts/validator.min.js')}}
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}


    <script type="text/javascript">

        function setImageFile(obj) {
            $(obj).parent().find("input[type=file]").click();
        }
        function removeImg(obj) {
            $(obj).parent().remove();
            $("#addImageBtn").data("count", parseInt($("#addImageBtn").data("count")) - 1);
            $("#imageAdd .images-input").show();

        }
        function updateFileImage(obj) {
            var $this = $(obj);
            var imageShow = $(obj).parent().find("img");
            var imageParent = $(obj).parent();
            var files = $(obj).prop('files');
            old_src = "/images/add-image.jpg";
            if (files.length) {
                var regex = /^(image\/jpeg|image\/png)$/;
                $.each(files, function (key, file) {
                    if (regex.test(file.type)) {
                        if (file.size <= 1048576) {
                            var fr = new FileReader();
                            fr.readAsDataURL(file);
                            fr.onload = function (event) {
                                $("#imageAdd .image-block").append(
                                        '<div class="fileinput-new images-input">' +
                                        '<img class="product-image-1" src="' + old_src + '" onclick="setImageFile(this)">' +
                                        '<input type="file" name="images[]" class="" class="product-file-1" onchange="updateFileImage(this)">' +
                                        '</div>'
                                );
                                $("#addImageBtn").data("count", parseInt($("#addImageBtn").data("count")) + 1);
                                if ($("#addImageBtn").data("count") >= 5) {
                                    $("#imageAdd .images-input").hide();
                                }
                                $(imageParent).append('<div class="close-image" onclick="removeImg(this)"><i class="glyphicon glyphicon-remove"></i></div>');
                                $(imageShow).attr('src', event.target.result);
                                $($this).removeClass('images-input');
                            };
                        } else {
                            alert("{{trans("index.hinhanhvuotqua1Mb")}}");
                        }
                    } else {
                        alert("{{trans("index.chonanhdinhdangjpg")}} ");
                    }
                });
            }
        }

        $("#quantityPlus").click(function () {
            var quantity = parseInt($("#quantity").val());
            if (quantity < 9) {
                $("#quantity").val(quantity + 1);
            }
        });

        $("#quantityMinus").click(function () {
            var quantity = parseInt($("#quantity").val());
            if (quantity > 1) {
                $("#quantity").val(quantity - 1);
            }
        });

        $("#upload_url").click(function () {
            var url_value = $("#url").val();
            var url = "{{URL::action('Frontend\ShopperController@order')}}";
            window.location.href = url + "?start=1&url=" + url_value;
        });
        var ComponentsSelect2 = function () {

            var handleDemo = function () {

                // Set the "bootstrap" theme as the default theme for all Select2
                // widgets.
                //
                // @see https://github.com/select2/select2/issues/2927
                $.fn.select2.defaults.set("theme", "bootstrap");

                var placeholder = "Select a State";

                $(".select2, .select2-multiple").select2({
                    placeholder: "{!! trans("index.diemxuatphat_select")!!} ",
                    width: null
                });
                $(".select21").select2({
                    placeholder: "{!! trans("index.diemden_select") !!}  ",
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

//        if (App.isAngularJsApp() === false) {
//            jQuery(document).ready(function () {
//                ComponentsSelect2.init();
//            });
//        }
        function showHiw(id) {
//            $(".how-it-work").hide();
//            $("#"+id).show();
        }
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true
        });
        $('.datepicker').datepicker('setStartDate', new Date());
        $("#updateInfoModal").modal();
        $(".select2-single").select2();
        $("#deliverTo").change(function () {
            if ($(this).val() == "") {
                $("#deliverFrom").hide();
            } else {
                if ($(this).val().length >= 3) {
                    console.log("123");
                    $("#deliverFrom").show();
                }
            }
        });
        //        $(".reward").click(function () {
        //            $(".reward").addClass("btn-outline");
        //            $(this).removeClass("btn-outline");
        //            $(".input-reward").val($(this).data("reward"));
        //        });
        $(".input-reward").change(function () {
            var rewardVal = $(this).val();

            if (parseFloat(rewardVal) < 5) {
                $(this).val("5");
            }

//            $(".reward").addClass("btn-outline");
//            $(".reward").each(function () {
//                if (rewardVal == $(this).data("reward")) {
//                    $(this).removeClass("btn-outline");
//                }
//            })
        })
    </script>
@endsection