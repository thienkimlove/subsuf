@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}
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
            <a href="{{URL::action('Admin\CategoryController@index')}}">Nhóm hàng hóa</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Sửa: {{$category->name}}</span>
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
                        <i class="fa fa-barcode font-green"></i>
                        <span class="caption-subject font-green bold uppercase">{{$category->name}}</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\CategoryController@update', $category->category_id], 'method' => 'POST',
                    'id' => 'update-category', 'data-toggle'=>'validator', 'files' => true])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Phân nhóm
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select required name="category_type" id="category_type" class="form-control">
                                        @foreach($category_types as $key => $type)
                                            <option value="{{$key}}"
                                                    @if($key == $category->category_type) selected @endif>{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên tiếng Việt
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input type="hidden" name="category_id" value="{{$category->category_id}}">
                                    <input required type="text" name="name_vi" id="name_vi" value="{{($category->translate('vi'))? $category->translate('vi')->name : ''}}"
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên tiếng Anh
                                        <span class="required" aria-required="true"> * </span>
                                    </label>

                                    <input required type="text" name="name_en" id="name_en" value="{{($category->translate('en'))? $category->translate('en')->name : ''}}"
                                           class="form-control">
                                </div>




                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ưu tiên
                                    </label>
                                    <input required type="text" name="category_order" id="category_order"
                                           class="form-control" value="{{$category->category_order}}">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Hiển thị</label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="is_showed" value="1"
                                                   @if($category->is_showed) checked @endif>
                                            Có
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="is_showed" value="0"
                                                   @if($category->is_showed == 0) checked @endif>
                                            Không
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Ảnh</label>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                            <img src="@if(isset($category->image)) {{$category->image}}
                                            @else http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=no+image
                                            @endif" alt="{{get_image_name($category->image)}}"/>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 200px; max-height: 200px;">
                                        </div>

                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Chọn ảnh </span>
                                                <span class="fileinput-exists"> Đổi ảnh </span>
                                                <input class="form-control" type="file" name="image" id="image"
                                                       value="{{get_image_name($category->image)}}">
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
@endsection