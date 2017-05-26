@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/bootstrap-summernote/summernote.css')}}
    {{Html::style('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}
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
            <a href="{{URL::action('Admin\StaticContentController@abouts')}}">About Me</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thêm</span>
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
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-info font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Thêm</span>
                    </div>

                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang About Me"
                           href="{{URL::action('Admin\StaticContentController@abouts')}}">
                            <i class="fa fa-undo"></i>
                        </a>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => 'Admin\StaticContentController@about_insert',
                    'method' => 'POST', 'id' => 'about-form', 'class'=>'form-horizontal form-bordered','data-toggle'=>'validator',
                    'enctype'=>'multipart/form-data'])}}
                    <div class="form-body">

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
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <a type="button" class="btn btn-sm green uppercase" id="insert_banner">
                                    Lưu
                                </a>
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
    {{Html::script('assets/global/plugins/bootstrap-summernote/summernote.min.js')}}
    {{Html::script('assets/pages/scripts/validator.min.js')}}
    {{Html::script('assets/global/plugins/bootstrap-toastr/toastr.min.js')}}

@endsection