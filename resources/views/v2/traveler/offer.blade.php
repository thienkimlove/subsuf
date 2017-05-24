

@extends('v2.template')

@section('content')
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
                            {{trans("index.banchuanhapdayduttoffer")}}
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" name="email" value="{{Session::get("userFrontend")["email"]}}"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
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
<div class="wrap_container wrap_quytrinhnhanmuaho">
    <div class="container">
        <div class="row">
            @include("frontend.message")
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <h1 class="title_block">{{trans("index.nhanmuaho")}}</h1>
                    {!! Form::open(['action' => ['Frontend\TravelerController@makeOffer',$order->order_id], 'method' => 'POST',"id"=>"offerForm", "class"=>'form_quytrinhnhanmuaho', "data-toggle"=>"validator"]) !!}
                    <div class="form-group">
                        <label for="sanPhamCanMua">{{trans("index.sanphamcanmua")}}</label>
                        <h2 class="name_product"><a href="#">{{$order->name}}</a></h2>
                        <p>Giá sản phẩm: <span>$90</span></p>
                    </div>
                    <div class="row">
                        <div class="form-group has-feedback col-xs-12 col-sm-6">
                            <label class="control-label" for="inputSuccess1">{{trans("index.tiencongkhonggomthue")}}</label>
                            <div class="wrap_input">
                                <input name="other_fee" type="text" id="shippingCheck" class="form-control" id="inputSuccess1" aria-describedby="inputSuccess1Status" value="$ 8">
                                <span class="glyphicon glyphicon-ok form-control-feedback check" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group has-feedback col-xs-12 col-sm-6">
                            <label class="control-label" for="inputSuccess2">{{trans("index.thuebotrongneukoco")}}</label>
                            <div class="wrap_input">
                                <input name="tax" type="text" class="form-control" id="inputSuccess2" aria-describedby="inputSuccess2Status" placeholder="0">
                                <span  class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group has-feedback col-xs-12 col-sm-6">
                            <label class="control-label" for="inputSuccess2">{{trans("index.phivanchuyenbotrongneukoco")}}</label>
                            <div class="wrap_input">
                                <input name="shipping_fee"  type="text" class="form-control" id="inputSuccess3" aria-describedby="inputSuccess3Status" placeholder="0">
                                <span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6">
                            <label for="diemXuanPhat">{{trans("index.vanchuyentu")}}</label>
                            {{Form::select("deliver_from",$country,"",["class"=>"form-control select2 select2-single"])}}
                        </div>
                        <div class="form-group col-xs-12 col-sm-6">
                            <label for="diemDen">Điểm đến</label>
                            <select class="form-control">
                                <option value="" disabled selected hidden>Điểm đến ( Thành Phố )</option>
                                <option>2</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6">
                            <label for="ngayGiaoHang">{{trans("index.ngaygiaohang")}}</label>
                            <input type="text" name="date" class="form-control" id="ngayGiaoHang" placeholder="{{trans("index.ngaygiaohang")}}" value="{{($order->delive_date)?date("d-m-Y",strtotime($order->delive_date)):""}}"">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ngayGiaoHang">{{trans("index.note")}}</label>
                        <textarea class="form-control" name="deliver_details" rows="3"></textarea>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
    @endsection
