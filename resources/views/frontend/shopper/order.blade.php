@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}

    {{Html::style('assets/pages/css/search.min.css')}}
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
            @include("frontend.message")
            <div class="portlet light">
                <h4 class="portlet-body form">
                    <span class="hidden-md hidden-lg uppercase">{{trans("index.thongtinsanpham")}}</span>

                    <div class="mt-element-step hidden-sm hidden-xs">
                        <div class="row step-line">
                            <div class="mt-step-desc">
                                <div class="col-md-4 mt-step-col first error">
                                    <div class="mt-step-number bg-white">
                                        <i class="icon-basket"></i>
                                    </div>
                                    <div class="mt-step-title uppercase font-grey-cascade">{{trans("index.thongtinsanpham")}}</div>
                                </div>
                                <div class="col-md-4 mt-step-col">
                                    <div class="mt-step-number bg-white">
                                        <i class="icon-credit-card"></i>
                                    </div>
                                    <div class="mt-step-title uppercase font-grey-cascade">{{trans("index.chitietgiaohang")}}
                                    </div>
                                </div>
                                <div class="col-md-4 mt-step-col last">
                                    <div class="mt-step-number bg-white">
                                        <i class="icon-rocket"></i>
                                    </div>
                                    <div class="mt-step-title uppercase font-grey-cascade">{{trans("index.taoyeucau")}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-8 text-center">
                            <hr>
                            {{--<h4> Provide us a few details about your item</h4>--}}
                            {{--<p>If you found your item online, paste the link to it below. To create a custom grab, type--}}
                            {{--out its--}}
                            {{--details below.</p>--}}
                        </div>
                    </div>
                    <div class="row">
                        {!! Form::open(['action' => 'Frontend\ShopperController@order2', 'method' => 'POST','id'=>'addPlanDetail', 'files' => true,"data-toggle"=>"validator"]) !!}
                        <div class="col-lg-12 margin-top-10">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="url" class="form-control" id="url"
                                           placeholder="{{trans('index.nhaplinksp')}}"
                                           value="@if(old("url")) {{old("url")}} @elseif(isset($order["link"])) {{$order['link']}} @endif">
                                    <span class="input-group-btn">
                                        <button class="btn green" type="button"
                                                id="upload_url">{{trans("index.tailen")}}</button>
                                    </span>
                                </div>
                                <hr>
                            </div>

                            <div id="imageAdd">
                                <p>{{trans("index.anhsanphamchon1")}}</p>
                                <div class="image-block">
                                    @if(isset($order["images"]))
                                        @foreach($order["images"] as $key=>$image)
                                            <?php if ($key >= 5) {
                                                break;
                                            }  ?>
                                            <div class="fileinput-new images-input">
                                                <div class="close-image" onclick="removeImg(this)"><i
                                                            class="glyphicon glyphicon-remove"></i></div>
                                                <img class="product-file-1"
                                                     src="{{URL::to($image)}}" alt="">

                                                <input type="hidden" name="images-link[]" value="{{$image}}">
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
                            <div class="form-group">
                                <label>{{trans("index.tensanpham")}}</label>
                                <textarea name="name" class="form-control" placeholder="{{trans("index.tensanpham")}}"
                                          maxlength="200"
                                          required>{{isset($order["name"])?$order["name"]:""}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.motasanpham")}}</label>
                                <textarea class="form-control" name="description" rows="3"
                                          placeholder="{{trans("index.mausackichco")}}" required
                                          maxlength="200">{{isset($order["description"])?$order["description"]:""}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.giasanpham")}} ({{$order['currency']}})</label>
                                <input class="form-control spinner" onkeypress='return (event.charCode >= 48 && event.charCode <= 57)||event.charCode==46' name="price" type="text" maxlength="7" step=any min="1"
                                       data-error="{{trans("index.price_min")}}"
                                       value="{{isset($order["price"])?$order["price"]:""}}" required="">
                                <div class="help-block with-errors"></div>

                                <p style="margin-top: 15px">
                                    <small>
                                        {{--<i>{!!  trans("index.neugiasanphankophaiusd")!!}</i>--}}
                                      {{--  <a class="font-blue"
                                       data-toggle="modal" href="#basic">
                                        <i class="fa fa-question-circle"></i> {{trans("index.tigiaquydoi")}}
                                       </a>--}}

                                        Quy doi sang <select name="exchange">

                                            @foreach($exchangeArr as $item)
                                                @if (($order['currency'] == '£' && $item->from_currency == 'EUR') || ($order['currency'] == '$' && $item->from_currency == 'USD' ))
                                                <option>{{ $item->to_currency }} Rate : {{number_format($item->money)}}</option>
                                                @endif

                                            @endforeach

                                        </select>

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

                                    <input type="text" name="quantity" maxlength="3" id="quantity" class="btn  border-red"
                                           value="{{isset($order["quantity"])?$order["quantity"]:"1"}}"
                                           style="width: 40px">
                                    <button type="button" class="btn btn-outline red bold" id="quantityPlus">+</button>
                                </div>
                            </div>

                            <div class="form-actions text-right">
                                <button type="submit" name="isorder" value="1"
                                        class="btn btn-circle green btn-lg">{{trans("index.tieptuc")}}
                                    <i
                                            class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                        {{Form::close()}}
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
                    <h4 class="modal-title">{{trans("index.tigiaquydoi")}}</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striper table-bordered">
                        <tr>
                            <th>
                                {{trans("index.loaitien")}}
                            </th>
                            <th>{{trans("index.quydoisang")}}</th>
                            <th>{{trans("index.tigia")}}</th>
                        </tr>
                        @foreach($exchangeArr as $item)
                            <tr>
                                <td>{{$item->from_currency}}</td>
                                <td>{{$item->to_currency}}</td>
                                <td>{{number_format($item->money)}}</td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="form-group">
                        <i>{!!  trans("index.neugiasanphankophaiusd")!!}</i>
                    </div>
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

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/pages/scripts/convert-image-to-base64.js')}}
    {{Html::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
    {{Html::script('assets/pages/scripts/validator.min.js')}}


    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true
        });
        $('.datepicker').datepicker('setStartDate', new Date());
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
                        alert("{{trans("index.chonanhdinhdangjpg")}}");
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
            window.location.href = url + "?start=1&url=" + encodeURIComponent(url_value);
        })
    </script>
@endsection