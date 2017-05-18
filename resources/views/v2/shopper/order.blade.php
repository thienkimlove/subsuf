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
                                    <div class="image">
                                        <a href="#">
                                            <img src="/v2/images/banner3.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="image">
                                        <a href="#">
                                            <img src="/v2/images/banner3.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="image">
                                        <a href="#">
                                            <img src="/v2/images/banner3.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="image-upload">
                                        <label for="file-input">
                                            <img src="http://goo.gl/pB9rpQ"/>
                                        </label>

                                        <input id="file-input" type="file"/>
                                    </div>
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
