@extends('v2.template')

@section('content')
<div class="wrap_container">

    <div class="wrap_QuyTrinhDatMuaHang">
        <section>
            <nav>
                <ol class="cd-multi-steps text-bottom count">
                    <li class="visited"><a href="#0">{{trans("index.thongtinsanpham")}}</a></li>
                    <li class="current"><em>{{trans("index.chitietgiaohang")}}</em></li>
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
                                        <input type="radio" checked="checked" name="input-reward" value="{{$reward[0]}}">
                                        ${{$reward[0]}}
                                    </label>
                                    <label class="btn btn-default">     <input type="radio" name="input-reward" value="{{$reward[1]}}">
                                        ${{$reward[1]}}
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" name="input-reward" value="{{$reward[2]}}">
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

    {{Html::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}



    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true
        });
        $('.datepicker').datepicker('setStartDate', new Date());

    </script>
@endsection
