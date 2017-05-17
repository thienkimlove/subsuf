


@extends('v2.template')

@section('content')

<div class="wrap_container">
    <div class="wrap_dathang_NhanMuaHo" style="background-image: url('images/banner3.jpg');">
        <div class="container">
            <div class="wrap-fomr">
                <h1 class="title_block">Tiếp kiệm lên tới vài trăm USD cho mỗi chuyến bay !</h1>
                <p>Dễ dàng kiếm thêm thu nhập bằng cách chuyển vài món đồ đến nơi bạn đang đi tới</p>
                <form class="form_select" action="">
                    <select class="selectpicker select" data-live-search="true" >
                        <option>Điểm xuất phát</option>
                        <option>Alaska </option>
                        <option>Arizona </option>
                    </select>
                    <select class="selectpicker select select2" data-live-search="true" >
                        <option>Điểm đến</option>
                        <option>Alaska </option>
                        <option>Arizona </option>
                    </select>
                    <button type="submit" class="btn btn_dathang">Bắt đầu đặt hàng</button>
                </form>
                <div class="text-center">
                    <a class="btn_link" href="#">CÁCH NHẬN MUA HỘ</a>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap_blog_home">
        <div class="container">
            <h2 class="title_block">
                <a href="#">
                    Kiếm thêm thu nhập với chuyến bay
                </a>
            </h2>
            <div class="list_post_blog row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="item_post">
                        <div class="image_title">
                            <a class="image" href="#">
                                <img src="images/banner1.jpg" alt="">
                            </a>
                            <h3 class="title">
                                <a href="#">Tìm yêu cầu đặt hàng</a>
                            </h3>
                        </div>
                        <div class="summary">
                            <p>Nhập và tìm các yêu cầu đặt hàng theo điểm đến của bạn</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="item_post">
                        <div class="image_title">
                            <a class="image" href="#">
                                <img src="images/banner3.jpg" alt="">
                            </a>
                            <h3 class="title">
                                <a href="#">Đề nghị mua hộ</a>
                            </h3>
                        </div>
                        <div class="summary">
                            <p>Tiền công sẽ bao gồm cả các loại thuế, phí cho sản phẩm ( nếu có )</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="item_post">
                        <div class="image_title">
                            <a class="image" href="#">
                                <img src="images/banner2.jpg" alt="">
                            </a>
                            <h3 class="title">
                                <a href="#">Vận chuyển và nhận tiền</a>
                            </h3>
                        </div>
                        <div class="summary">
                            <p>Sau khi người mua nhận được đồ, chúng tôi sẽ tiến hành chuyển tiền</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap_exhibition_home color_bg_sub">
        <div class="container">
            <h2 class="title_block">
                <a href="#">
                    Những đơn hàng thành công gần đây
                </a>
            </h2>
            <div class="slider_exhibition_u">
                <div class="row">
                    @foreach($orderList as $order)
                    <div class="item col-xs-12 col-sm-6 col-md-4">
                        <div class="box_exhibition">
                            <div class="image_exhibition">
                                <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">
                                    <img src="@if(count($order->order_images)) {{URL::to($order->order_images[0]->image)}} @endif"/>
                                </a>

                            </div>
                            <div class="info_exhibition">
                                <div class="wrap_user">
                                    <div class="user_item">
                                        <a href="#">
                                            <img alt="" class="img-circle" src="{{URL::to($order->account["avatar"])}}">

                                        </a>
                                        <div class="name_datetime">
                                            <a class="name_user" href="#">{{$order->account["first_name"]}} {{$order->account["last_name"]}}</a>
                                            <span class="datetime">
                                                    {{reltativeDate(date("d-m-Y H:i:s",strtotime($order->request_time)))}}
                                                </span>
                                        </div>
                                    </div>
                                    <h4 class="name_product">
                                        <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}">{{$order->name}}</a>
                                    </h4>
                                    <div class="to_from">
                                        <span class="to">{{$order->to_location->name}}</span>
                                        đến
                                        <span class="from">{{$order->from_location->name}}</span>
                                    </div>
                                </div>
                                <div class="wage">



                                    Tiền công:
                                    @if($order->offers->count()==0)

                                    <span>$80</span>

                                        @@endif


                                </div>
                                <div class="text-center">
                                    <a href="{{URL::action("Frontend\ShopperController@orderDetail",$order->order_id)}}" class="btn_style">{{trans("index.nhanmuaho")}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endforeach
                </div>
                <nav class="text-center" aria-label="Page navigation">
                    <ul class="pagination">
                        <li>
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

</div>


@endsection