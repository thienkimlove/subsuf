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
                            <label class="control-label col-md-2">
                                Ngôn ngữ
                            </label>
                            <div class="col-md-10">
                                <select name="language" id="language" class="form-control">
                                    @foreach($languages as $language)
                                        <option value="{{$language->language_code}}"
                                                @if($language->language_code == old('language')) selected @endif>{{$language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-2">
                                Tiêu đề <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-md-10">
                                <input required type="text" name="title" class="form-control" value="{{old('title')}}">
                            </div>
                        </div>

                        <div class="form-group form-group-sm last">
                            <label class="control-label col-md-2">Nội dung</label>
                            <div class="col-md-10">
                                <textarea name="content" class="summernote">{{old('content')}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <a type="button" class="btn btn-sm green uppercase" id="insert_about">
                                    Lưu
                                </a>
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
    {{Html::script('assets/global/plugins/bootstrap-toastr/toastr.min.js')}}

    <script>
        $("#insert_about").click(function () {
            var language = $("#language").val();
            $.ajax({
                url: '{{URL::action('Admin\StaticContentController@check_about')}}',
                type: 'GET',
                data: {
                    'language': language
                },
                dataType: 'text',
                timeout: 30000,
                success: function (data) {
                    if (data == 1) {
                        toastr.options.closeButton = true;
                        toastr.error('About Me đã có ngôn ngữ ' + $("#language").find("option:selected").text(), 'Thông báo');
                        return false;
                    } else {
                        $("#about-form").submit();
                    }
                },
                error: function (data) {
                    toastr.options.closeButton = true;
                    toastr.error('Vui lòng thử lại', 'Thông báo');
                    return false;
                }
            });
        });
    </script>
@endsection