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
                        <form>
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label for="diemXuanPhat">Điểm xuất phát</label>
                                    <select class="form-control">
                                        <option value="" disabled selected hidden>Điểm xuất phát ( Có thể bỏ trống )</option>
                                        <option>2</option>
                                    </select>
                                </div>
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label for="diemDen">Điểm đến</label>
                                    <select class="form-control">
                                        <option value="" disabled selected hidden>Điểm đến ( Thành Phố )</option>
                                        <option>2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tenSanPham">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="tenSanPham" placeholder="Tên sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="ngayGiaoHang">Ngày giao hàng<br><small>(Bỏ trống để nhận nhiều đề nghị mua hộ hơn)</small></label>
                                <input type="text" class="form-control" id="ngayGiaoHang" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="tienCong">Nhập tiền công cho người mua hộ <br><small>Tiền công sẽ bao gồm các loại thuế, phí cho sản phẩm (nếu có)</small></label>
                                <div class="wrap_tiencong text-right" data-toggle="buttons">
                                    <span class="pull-left">Gợi ý tiền công</span>
                                    <label class="btn btn-default">
                                        <input type="radio" name="q1" value="0">
                                        $5
                                    </label>
                                    <label class="btn btn-default">     <input type="radio" name="q1" value="1">
                                        $10
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" name="q1" value="2">
                                        $15
                                    </label>
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
