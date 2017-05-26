@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/bootstrap-summernote/summernote.css')}}
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
            <a href="{{URL::action('Admin\StaticContentController@banners')}}">Banners</a>
            <i class="fa fa-angle-right"></i>
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
        <div class="col-md-12">
            <div class="portlet light form-fit bordered">

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\StaticContentController@banner_update', $banner->id],
                    'method' => 'POST', 'id' => 'about-form', 'class'=>'form-horizontal form-bordered','data-toggle'=>'validator',
                    'enctype'=>'multipart/form-data'])}}
                    <div class="form-body">
                        <div class="form-group form-group-sm">
                            <label class="control-label">Ảnh</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                    <img src="{{ $banner->image }}"/>
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
                        <input type="hidden" name="order" value="{{ $banner->order }}">
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-sm green uppercase">
                                    Lưu
                                </button>
                                <a role="button" class="btn btn-sm btn-default uppercase"
                                   href="{{URL::action('Admin\StaticContentController@banners')}}">
                                    Hủy
                                </a>
                            </div>
                        </div>
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