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
            <a href="#">Quản lý Danh mục</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\WebsiteController@index')}}">Website</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thêm Website</span>
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
                        <i class="fa fa-chrome font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Thêm Website</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => 'Admin\WebsiteController@insert', 'method' => 'POST', 'files' => true,
                    'id' => 'insert-website', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên trang web Tiếng Việt
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name_vi" id="name_vi" class="form-control">
                                </div>


                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên trang web Tiếng Anh
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name_en" id="name_en" class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Link web
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="link" id="link" class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Quốc gia
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select name="location_id" id="location_id" required
                                            class="form-control input-sm select2-auto">
                                        <option value="" selected>--- Chọn quốc gia ---</option>
                                        @foreach($locations as $location)
                                            <option value="{{$location->location_id}}"
                                                    @if(old('location_id') == $location->location_id) selected @endif>{{$location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm" style="margin-bottom: 0">
                                    <label class="control-label">
                                        Nhóm hàng hóa
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select name="category_id" id="category_id" required
                                            class="form-control input-sm select2-auto">
                                        <option value="" selected>--- Chọn nhóm hàng hóa ---</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->category_id}}"
                                                    @if(old('category_id') == $category->category_id) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ưu tiên
                                    </label>
                                    <input required type="text" name="website_order" id="website_order"
                                           class="form-control" value="1">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Hiển thị</label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="is_showed" value="1">
                                            Có
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="is_showed" value="0" checked>
                                            Không
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mô tả ngắn Tiếng Việt
                                    </label>
                                    <textarea class="form-control" rows="3" name="description_vi"
                                              maxlength="250"></textarea>
                                </div>


                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mô tả ngắn Tiếng Anh
                                    </label>
                                    <textarea class="form-control" rows="3" name="description_en"
                                              maxlength="250"></textarea>
                                </div>

                                <label class="control-label">Ảnh</label>
                                <div class="form-group form-group-sm">
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
                           href="{{URL::action('Admin\WebsiteController@index')}}">
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