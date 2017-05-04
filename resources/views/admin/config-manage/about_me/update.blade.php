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
            <a href="{{URL::action('Admin\StaticContentController@abouts')}}">About Me</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Ngôn ngữ: {{$about->language_ref->name}}</span>
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
                        <span class="caption-subject font-green bold uppercase">Ngôn ngữ: {{$about->language_ref->name}}</span>
                    </div>

                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang About Me"
                           href="{{URL::action('Admin\StaticContentController@abouts')}}">
                            <i class="fa fa-undo"></i>
                        </a>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\StaticContentController@about_update', $about->language],
                    'method' => 'POST', 'id' => 'about-form', 'class'=>'form-horizontal form-bordered','data-toggle'=>'validator',
                    'enctype'=>'multipart/form-data'])}}
                    <div class="form-body">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-2">
                                Ngôn ngữ
                            </label>
                            <div class="col-md-10">
                                <div class="form-control">{{$about->language_ref->name}}</div>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-2">
                                Tiêu đề <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-md-10">
                                <input required type="text" name="title" class="form-control"
                                       value="{{$about->title}}">
                            </div>
                        </div>

                        <div class="form-group form-group-sm last">
                            <label class="control-label col-md-2">Nội dung</label>
                            <div class="col-md-10">
                                <textarea name="content" class="summernote">{{$about->content}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-sm green uppercase">
                                    Lưu
                                </button>
                                <a role="button" class="btn btn-sm btn-default uppercase"
                                   href="{{URL::action('Admin\StaticContentController@abouts')}}">
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
@endsection