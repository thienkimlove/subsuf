@extends('v2.template')

@section('content')
<div class="wrap_container">

    <div class="wrap_QuyTrinhDatMuaHang">
        <section>
            <nav>
                <ol class="cd-multi-steps text-bottom count">
                    <li class="current"><a href="#0">{{trans("index.thongtinsanpham")}}</a></li>
                    <li><em>{{trans("index.chitietgiaohang")}}</em></li>
                    <li><em>{{trans("index.taoyeucau")}}</em></li>
                </ol>
            </nav>
        </section>
        <div class="wrap_form color_bg_sub">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-10 col-md-offset-1">
                        <form>
                            <div class="form-group">
                                <label for="nhapLinkSanPham">{{trans('index.nhaplinksp')}}</label>
                                <input type="text" class="form-control" id="nhapLinkSanPham" placeholder="{{trans('index.nhaplinksp')}}">
                            </div>
                            <div class="form-group">
                                <label for="tenSanPham">{{trans("index.tensanpham")}}</label>
                                <input type="text" class="form-control" id="tenSanPham" placeholder="Tên sản phẩm" value="{{isset($order["name"])?$order["name"]:""}}">
                            </div>
                            <div class="form-group">
                                <label for="moTaSanPham">{{trans("index.motasanpham")}}</label>
                                <input type="text" class="form-control" id="moTaSanPham" placeholder="{{trans("index.mausackichco")}}" value="{{isset($order["description"])?$order["description"]:""}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Ảnh sản phẩm <br><small>(Chọn ít nhất 1 ảnh)</small></label>
                                <div class="wrap_image_upload">
                                    @if(isset($order["images"]))
                                        @foreach($order["images"] as $key=>$image)
                                            @if ($key < 5)
                                                <div class="image fileinput-new images-input">
                                                    <div class="close-image" onclick="removeImg(this)"><i
                                                                class="glyphicon glyphicon-remove"></i></div>
                                                        <img src="{{URL::to($image)}}" alt="">
                                                    <input type="hidden" name="images-link[]" value="{{$image}}">
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                        <div class="image-upload fileinput-new images-input"
                                             @if(isset($order["images"])) @if(count($order["images"])>=5)
                                             style="display: none" @endif @endif>
                                            <label for="file-input-n">
                                            <img id="addImageBtn" class="product-file-1"
                                                 src="http://goo.gl/pB9rpQ" alt=""
                                                 data-count="@if(isset($order["images"])) {{(count($order["images"])<5) ? count($order["images"]):5}} @else 0 @endif"
                                                 onclick="setImageFile(this)"
                                            >
                                            </label>
                                            <input id="file-input-n" type="file" name="images[]" class="hidden" class="product-file-1"
                                                   onchange="updateFileImage(this)">
                                        </div>

                                    {{--<div class="image-upload">--}}
                                        {{--<label for="file-input">--}}
                                            {{--<img src="http://goo.gl/pB9rpQ"/>--}}
                                        {{--</label>--}}

                                        {{--<input id="file-input" type="file"/>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    @endsection


@section('frontend_script')
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
                                    '<div class="image fileinput-new images-input">' +
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
