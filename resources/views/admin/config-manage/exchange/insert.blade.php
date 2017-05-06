@extends('admin.layout.master')
@section('style')
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Quản lý cấu hình</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\ExchangeController@index')}}">Tỷ giá</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thêm Tỷ giá</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">

        </div>
    </div>
@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-exchange font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Thêm Tỷ giá</span>
                    </div>

                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang Tỷ giá"
                           href="{{URL::action('Admin\ExchangeController@index')}}">
                            <i class="fa fa-undo"></i>
                        </a>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => 'Admin\ExchangeController@insert', 'method' => 'POST', 
                    'id' => 'exchange-form', 'data-toggle'=>'validator',])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Đơn vị Nguồn
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" data-minlength="3" data-maxlength="10" maxlength="10"
                                           name="from_currency" id="from_currency" class="form-control"
                                           data-error="Đơn vị tiền từ 3 đến 10 ký tự">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Đơn vị Đích
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" data-minlength="3" data-maxlength="10" maxlength="10"
                                           name="to_currency" id="to_currency" class="form-control"
                                           data-error="Đơn vị tiền từ 3 đến 10 ký tự">
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Giá trị quy đổi
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="number" step=0.01 name="money" id="money" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-sm green uppercase">
                            Lưu
                        </button>
                        <a role="button" class="btn btn-sm btn-default uppercase"
                           href="{{URL::action('Admin\ExchangeController@index')}}">
                            Hủy
                        </a>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/pages/scripts/validator.min.js')}}
@endsection