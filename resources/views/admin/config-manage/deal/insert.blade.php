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
                        <span class="caption-subject font-green bold uppercase">Thêm Popup</span>
                    </div>

                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang Tỷ giá"
                           href="{{URL::action('Admin\DealController@index')}}">
                            <i class="fa fa-undo"></i>
                        </a>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => 'Admin\DealController@insert', 'method' => 'POST',
                    'id' => 'deal-form', 'data-toggle'=>'validator', 'files' => true])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tiêu đề tiếng Việt
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="title_vi" id="title_vi" value=""
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tiêu đề tiếng Anh
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="title_en" id="title_en" value=""
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mô tả tiếng Việt
                                    </label>
                                    <textarea class="form-control" rows="3" name="desc_vi"
                                              maxlength="250"></textarea>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mô tả tiếng Anh
                                    </label>
                                    <textarea class="form-control" rows="3" name="desc_en"
                                              maxlength="250"></textarea>
                                </div>



                                <div class="form-group form-group-sm">
                                    <label class="control-label">Ảnh</label>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                            <img src="http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=no+image"/>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 200px; max-height: 200px;">
                                        </div>

                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Chọn ảnh </span>
                                                <span class="fileinput-exists"> Đổi ảnh </span>
                                                <input class="form-control" type="file" name="image" id="image">
                                            </span>
                                            <a href="javascript:;" class="btn default fileinput-exists"
                                               data-dismiss="fileinput"> Xóa ảnh </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-sm green uppercase">
                            Lưu
                        </button>
                        <a role="button" class="btn btn-sm btn-default uppercase"
                           href="{{URL::action('Admin\DealController@index')}}">
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
    {{Html::script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}
@endsection