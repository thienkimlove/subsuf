@extends('admin.layout.master')
@section('style')
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i> </a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Quản lý Danh mục</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\LanguageController@index')}}">Ngôn ngữ</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Sửa: {{$language->name}}</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')

@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            &nbsp;
        </div>

        <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Ngôn ngữ: {{$language->name}}</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\LanguageController@update', $language->language_code], 'method' => 'POST', 'id' => 'update-language', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mã
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" data-minlength="2" data-maxlength="5"
                                           name="language_code" id="language_code" class="form-control"
                                           data-error="Mã ngôn ngữ từ 2 đến 5 ký tự"
                                           value="{{$language->language_code}}">
                                    <div class="help-block with-errors"></div>
                                </div>
                            
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name" id="name" class="form-control"
                                           value="{{$language->name}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-sm green uppercase">
                            Lưu
                        </button>
                        <a role="button" href="{{URL::previous()}}" class="btn btn-sm btn-default uppercase">
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