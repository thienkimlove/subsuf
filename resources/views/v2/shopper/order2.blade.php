@extends('v2.template')

@section('content')
<div class="wrap_container">

    <div class="wrap_QuyTrinhDatMuaHang">
        <section>
            <nav>
                <ol class="cd-multi-steps text-bottom count">
                    <li class="visited"><a href="#0">{{trans("index.thongtinsanpham")}}</a></li>
                    <li class="current">{{trans("index.chitietgiaohang")}}</li>
                    <li><em>{{trans("index.taoyeucau")}}</em></li>

                </ol>
            </nav>
        </section>
        <div class="wrap_form color_bg_sub">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-10 col-md-offset-1">
                        {!! Form::open(['action' => 'Frontend\ShopperController@order3', 'method' => 'GET',"data-toggle"=>"validator"]) !!}
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label for="diemXuanPhat">{{trans("index.tu")}}</label>
                                    {{Form::select("deliver_from",$country,($order2["deliver_from"])?$order2["deliver_from"]:"",["class"=>"form-control select2"])}}
                                </div>
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label for="diemDen">{{trans("index.den")}}</label>
                                    {{Form::select("deliver_to",$province,($order2["deliver_to"])?$order2["deliver_to"]:"",["id"=>"deliverTo","class"=>"form-control select21","required"=>"required"])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ngayGiaoHang">{{trans("index.ngaygiaohang")}}<br><small>{{trans("index.botrongdenhannhieudenghihon")}}</small></label>
                                <input type="text" class="form-control datepicker" id="ngayGiaoHang" name="deliver_date" placeholder="" @if(isset($order2["deliver_date"])){{$order2["deliver_date"]}} @endif>
                            </div>
                            <div class="form-group">
                                <label for="tienCong">{{trans("index.nhaptienchonguoimuaho")}} <br><small>{{trans("index.tiencongbaogomthueneuco")}}</small></label>
                                <div class="wrap_tiencong text-right" data-toggle="buttons">
                                    <span class="pull-left">{{trans("index.goiytiencong")}}</span>
                                    <label class="btn btn-default">
                                        <input type="radio" name="q1" value="0">
                                        ${{$reward[0]}}
                                    </label>
                                    <label class="btn btn-default">     <input type="radio" name="q1" value="1">
                                        ${{$reward[1]}}
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" name="q1" value="2">
                                        ${{$reward[2]}}
                                    </label>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a href="{{URL::action("Frontend\ShopperController@order")}}"
                                           class="btn btn-default btn-circle btn"> <i
                                                    class="fa fa-arrow-left"></i> {{trans("index.quaylai")}} </a>
                                    </div>
                                    <div class="col-xs-6  text-right">
                                        <button type="submit"
                                                class="btn btn-circle green btn">{{trans("index.tieptuc")}} <i
                                                    class="fa fa-arrow-right"></i></button>
                                    </div>
                                </div>

                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@if(!Session::get("userFrontend")["phone_number"]||!Session::get("userFrontend")["email"])

    <div id="updateInfoModal" class="modal fade" tabindex="-1" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{trans("index.capnhatthongtin")}}</h4>
                </div>
                {!! Form::open(['action' => 'Frontend\UserController@updateInfo', 'method' => 'POST',"data-toggle"=>"validator"]) !!}
                <div class="modal-body">
                    <div class="alert alert-warning">
                        {{trans("index.banchuanhapdayduttorder")}}
                    </div>
                    <div class="form-group">
                        <label>Email<span class="font-yellow-gold"> ({{trans("index.moithongbaoduocguiquaemail")}}
                                )</span></label>
                        <input class="form-control" name="email" value="{{Session::get("userFrontend")["email"]}}"
                               required>
                    </div>
                    <div class="form-group">
                        <label>{{trans("index.dienthoai")}}</label>
                        <input class="form-control" name="phone"
                               value="{{Session::get("userFrontend")["phone_number"]}}"
                               required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn green">{{trans("index.capnhat")}}</button>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
@endif
    @endsection

@section('frontend_script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}

    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/pages/scripts/convert-image-to-base64.js')}}
    {{Html::script('assets/global/plugins/icheck/icheck.min.js')}}
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}

    {{Html::script('assets/pages/scripts/validator.min.js')}}

    <script type="text/javascript">
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
        $(".reward").click(function () {
            $(".reward").addClass("btn-outline");
            $(this).removeClass("btn-outline");
            $(".input-reward").val($(this).data("reward"));
        });
        $(".input-reward").change(function () {
            var rewardVal = $(this).val();

            if (parseFloat(rewardVal) < 5) {
                $(this).val("5");
            }

            $(".reward").addClass("btn-outline");
            $(".reward").each(function () {
                if (rewardVal == $(this).data("reward")) {
                    $(this).removeClass("btn-outline");
                }
            })
        })

    </script>
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
        function showHiw(id) {
//            $(".how-it-work").hide();
//            $("#"+id).show();
        }

    </script>
@endsection
