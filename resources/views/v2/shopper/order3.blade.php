@extends('v2.template')

@section('content')

    <div class="wrap_container">

    <div class="wrap_ChiTietDonHang">
        <div class="container">
            <h1 class="title_block">
                {{trans("index.chitietdonhang")}}
            </h1>
            <p class="title_block_sub">
                {{trans("index.chitietdonhang_detail")}}
            </p>
            <div class="row">
                <div class="col-xs-12 col-sm-7 col-md-7">
                    <div class="wrap_product">
                        <div class="slider_image">
                            <div class="owl-carousel owl-theme owl-slider_image_chitietdonhang">
                                @foreach($order["images"] as $image)
                                <div class="item">
                                    <a href="#">
                                        <img src="{{URL::to($image)}}" alt="">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="info_product">
                            <h3 class="name_product">
                                <a href="#">{{$order["name"]}}</a>
                            </h3>
                            <p>
                                {{$order["description"]}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-4 col-md-offset-1">
                    <div class="wrap_info_donhang">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>{{trans("index.tiencongngmuaho")}}:</td>
                                <td><span>${{number_format($order2["input-reward"], 2)}}</span></td>
                            </tr>
                            <tr>
                                <td>{{trans("index.giasanpham")}}:</td>
                                <td><span>${{$order["quantity"]}} x ${{number_format($order["price"],2)}}</span></td>
                            </tr>
                            <tr>
                                <td>{{trans("index.phidichvu")}} : </td>
                                <td><span>${{number_format($fee,2)}}</span></td>
                            </tr>
                            </tbody>
                            <tbody>
                            <tr>
                                <td><small>{{trans("index.tu")}}</small></td>
                                <td>{{($deliver_from)?$deliver_from->name:trans("index.batkydau")}}</td>
                            </tr>
                            <tr>
                                <td><small>{{trans("index.den")}}</small></td>
                                <td>{{($deliver_to)?$deliver_to->name:""}}</td>
                            </tr>
                            <tr>
                                <td><small>{{trans("index.ngaygiaohang")}}</small></td>
                                <td>{{date("d-m-Y", strtotime($order2["deliver_date"]))}}</td>
                            </tr>
                            <tr>
                                <td><small>Mua từ</small></td>
                                <td>www.amazon.com</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form">
                    <div class="form-group">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="{{URL::action("Frontend\ShopperController@order")}}"
                                       class="btn btn-default btn-circle btn"> <i
                                                class="fa fa-arrow-left"></i> {{trans("index.quaylai")}}
                                    </a>
                                </div>
                                <div class="col-xs-6  text-right">
                                    <button type="submit"
                                            class="btn btn-circle green btn">{{trans("index.tieptuc")}} <i
                                                class="fa fa-arrow-right"></i></button>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div></form>
                </div>
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        {{trans("index.dambaoantoanchonguoimuaho")}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    @endsection
