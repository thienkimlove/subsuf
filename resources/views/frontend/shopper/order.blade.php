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
                                            @if ($key < 5)
                                            <div class="fileinput-new images-input">
                                                <div class="close-image" onclick="removeImg(this)"><i
                                                            class="glyphicon glyphicon-remove"></i></div>
                                                <img class="product-file-1"
                                                     src="{{URL::to($image)}}" alt="">

                                                <input type="hidden" name="images-link[]" value="{{$image}}">
                                            </div>
                                            @endif
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
                                <label>{{trans("index.giasanpham")}} <select id="currency_select">
                                            @foreach (['USD', 'GBP', 'JPY'] as $currency)
                                                <option value="{{$currency}}" {{(isset($order['display_currency']) && $order['display_currency'] == $currency)? "selected" : "" }}>{{$currency}}</option>
                                            @endforeach
                                        </select></label>
                                <input class="form-control spinner"
                                       onkeypress='return (event.charCode >= 48 && event.charCode <= 57)||event.charCode===46'
                                       name="display_price"
                                       type="text"
                                       id="price_value"
                                       maxlength="7"
                                       step=any
                                       min="1"
                                       data-error="{{trans("index.price_min")}}"
                                       value="{{isset($order["display_price"])? $order["display_price"]: 0}}" required="">
                                <div class="help-block with-errors"></div>


                                <p style="display: none;margin-top: 15px;" id="real_price">
                                    <small id="display_price">
                                    </small> <b id="hide_this_b" style="display: none">USD</b>
                                    <input type="hidden" id="real_price_value" name="price" value="{{isset($order["price"])? $order["price"]: 0}}" />
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

        function updateRealPrice() {
            var baseUrl = '{{ url('/') }}';
            var currency = $('#currency_select').val();
            var inputPrice = $('#price_value').val();

            if (currency !== 'USD') {
                $.get(baseUrl +'/real_price',{ currency : currency, price : inputPrice },function(res){
                    if (res.response) {
                        $('#real_price_value').val(res.response);
                        $('#real_price').show();
                        $('#hide_this_b').show();
                        $('#display_price').text(res.response);
                    }
                });
            } else {
                $('#real_price').show();
                $('#display_price').text('');
                $('#hide_this_b').hide();
                $('#real_price_value').val(inputPrice);
            }
        }

        updateRealPrice();

        $('#currency_select').change(function(){
            updateRealPrice();
            return false;
        });

        $('#price_value').change(function(){
            updateRealPrice();
            return false;
        });

    </script>
@endsection