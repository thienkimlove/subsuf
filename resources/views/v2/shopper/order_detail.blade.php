


@extends('v2.template')

@section('content')


    <div class="wrap_container">

    <div class="wrap_ChiTietDonHang">
        <div class="container">
            <h1 class="title_block">
                Chi tiết đơn hàng
            </h1>
            <p class="title_block_sub">
                Vui lòng xem lại chi tiết đơn hàng. Sau khi hoàn thành, yêu cầu của bạn sẽ được hiển thị trên trang dành cho người mua hộ
            </p>
            <div class="row">
                <div class="col-xs-12 col-sm-7 col-md-7">
                    <div class="wrap_product">
                        <div class="slider_image">
                            <div class="owl-carousel owl-theme owl-slider_image_chitietdonhang">
                                @foreach($order->order_images as $image)
                                <div class="item">
                                    <a href="#">
                                        <img src="{{URL::to($image->image)}}" alt="">
                                    </a>
                                </div>
                                    @endforeach
                            </div>
                        </div>
                        <div class="info_product">
                            <h3 class="name_product">
                                <a href="#">{{$order->name}}</a>
                            </h3>
                            <p>
                                {{$order->description}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-4 col-md-offset-1">
                    <div class="wrap_info_donhang">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Tiền Công:</td>
                                <td><span>${{number_format($order->traveler_reward,2)}}</span></td>
                            </tr>
                            <tr>
                                <td>Giá sản phẩm:</td>
                                <td><span>$35.00</span></td>
                            </tr>
                            <tr>
                                <td>Phí dịch vụ: </td>
                                <td><span>$3.15</span></td>
                            </tr>
                            </tbody>
                            <tbody>
                            <tr>
                                <td><small>Từ</small></td>
                                <td>Anywhere</td>
                            </tr>
                            <tr>
                                <td><small>Đến</small></td>
                                <td>Hanoi</td>
                            </tr>
                            <tr>
                                <td><small>Ngày giao hàng</small></td>
                                <td>04/05/2017</td>
                            </tr>
                            <tr>
                                <td><small>Mua từ</small></td>
                                <td>www.amazon.com</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
