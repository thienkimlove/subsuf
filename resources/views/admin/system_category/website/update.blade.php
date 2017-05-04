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
            <a href="{{URL::action('Admin\WebsiteController@index')}}">Website</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Sửa: {{$website->name}}</span>
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
                        <span class="caption-subject font-green bold uppercase">{{$website->name}}</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\WebsiteController@update', $website->website_id], 'method' => 'POST',
                    'id' => 'update-website', 'data-toggle'=>'validator', 'files' => true])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên nhãn hiệu
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name" id="name" class="form-control"
                                           value="{{$website->name}}">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Trang web
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="link" id="link" class="form-control"
                                           value="{{$website->link}}">
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
                                                    @if($website->location_id == $location->location_id) selected @endif>{{$location->name}}</option>
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
                                                    @if($website->category_id == $category->category_id) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ưu tiên
                                    </label>
                                    <input required type="text" name="website_order" id="website_order"
                                           class="form-control" value="{{$website->website_order}}">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Hiển thị</label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="is_showed" value="1"
                                                   @if($website->is_showed) checked @endif>
                                            Có
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="is_showed" value="0"
                                                   @if($website->is_showed == 0) checked @endif>
                                            Không
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mô tả ngắn
                                    </label>
                                    <textarea class="form-control" rows="3" name="description"
                                              maxlength="250">{!! $website->description !!}</textarea>
                                </div>

                                <label class="control-label">Ảnh</label>
                                <div class="form-group form-group-sm">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                            <img src="@if(isset($website->image)) {{$website->image}}
                                            @else http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=no+image
                                            @endif" alt="{{get_image_name($website->image)}}"/>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 200px; max-height: 200px;">
                                        </div>

                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Chọn ảnh </span>
                                                <span class="fileinput-exists"> Đổi ảnh </span>
                                                <input class="form-control" type="file" name="image" id="image"
                                                       value="{{get_image_name($website->image)}}">
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