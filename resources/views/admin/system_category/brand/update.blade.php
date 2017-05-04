@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}

    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i> </a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Quản lý Admin</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\BrandController@index')}}">Thương hiệu</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Sửa: {{$brand->name}}</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')

@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-amazon font-green"></i>
                        <span class="caption-subject font-green bold uppercase">{{$brand->name}}</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\BrandController@update', $brand->brand_id], 'method' => 'POST',
                    'id' => 'update-brand', 'data-toggle'=>'validator', 'files' => true])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên thương hiệu
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name" id="name" class="form-control"
                                           value="{{$brand->name}}">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Trang chủ
                                    </label>
                                    <input type="text" name="link" id="link" class="form-control"
                                           value="{{$brand->link}}">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Nhãn
                                    </label>
                                    <input type="text" name="label" id="label" class="form-control"
                                           value="{{$brand->label}}">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mô tả
                                    </label>
                                    <textarea name="description" id="description" style="resize: none;" rows="5"
                                              class="form-control">{{$brand->description}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Ảnh</label>
                                <div class="form-group form-group-sm">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                            <img src="@if(isset($brand->logo)) {{$brand->logo}}
                                            @else http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=no+image
                                            @endif" alt="{{get_image_name($brand->logo)}}"/>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 200px; max-height: 200px;">
                                        </div>

                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Chọn ảnh </span>
                                                <span class="fileinput-exists"> Đổi ảnh </span>
                                                <input class="form-control" type="file" name="logo" id="logo"
                                                       value="{{get_image_name($brand->logo)}}">
                                            </span>
                                            <a href="javascript:;" class="btn default fileinput-exists"
                                               data-dismiss="fileinput"> Xóa ảnh </a>
                                        </div>
                                    </div>
                                </div>

                                <label class="control-label">Ảnh</label>
                                <div class="form-group form-group-sm">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 300px; height: 200px;">
                                            <img src="@if(isset($brand->cover)) {{$brand->cover}}
                                            @else http://www.placehold.it/300x200/EFEFEF/AAAAAA&amp;text=no+image
                                            @endif" alt="{{get_image_name($brand->cover)}}"/>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 300px; max-height: 200px;">
                                        </div>

                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Chọn ảnh </span>
                                                <span class="fileinput-exists"> Đổi ảnh </span>
                                                <input class="form-control" type="file" name="cover" id="cover"
                                                       value="{{get_image_name($brand->cover)}}">
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
    {{Html::script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}
@endsection