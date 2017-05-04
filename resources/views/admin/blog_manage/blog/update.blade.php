@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/bootstrap-summernote/summernote.css')}}
    {{Html::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Quản lý Blog</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\BlogController@index')}}">Bài viết</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Sửa</span>
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
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-rss font-green"></i>
                        <span class="caption-subject font-green bold uppercase">{{$blog->title}}</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\BlogController@update', $blog->blog_id], 'method' => 'POST', 'files' => true,
                    'id' => 'update-blog', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ngôn ngữ
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select required name="language" id="language" class="form-control">
                                        <option value="">Chọn Ngôn ngữ</option>
                                        @foreach($languages as $language)
                                            <option value="{{$language['language_code']}}"
                                                    @if($language['language_code'] == $blog->language) selected @endif>{{$language['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Thể loại
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select required name="category_id" id="category_id" class="form-control">
                                        <option value="">Chọn Thể loại</option>
                                        @foreach($blogCategories as $blogCategory)
                                            <option value="{{$blogCategory['category_id']}}"
                                                    data-language="{{$blogCategory['language']}}"
                                                    @if($blogCategory['category_id'] == $blog->category_id) selected @endif>{{$blogCategory['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tiêu đề
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="title" value="{{$blog->title}}" id="title"
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Slug
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="slug" value="{{$blog->slug}}" id="slug"
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tác giả
                                    </label>
                                    <input disabled type="text" value="{{$blog->author->name}}"
                                           class="form-control">
                                    <input type="hidden" name="author_id" value="{{$blog->author_id}}"
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Ảnh bài viết</label>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 300px; height: 200px;">
                                            <img src="@if(isset($blog->image)) {{$blog->image}}
                                            @else http://www.placehold.it/300x200/EFEFEF/AAAAAA&amp;text=no+image
                                            @endif" alt="{{get_image_name($blog->image)}}"/>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 300px; max-height: 200px;">
                                        </div>

                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Chọn ảnh </span>
                                                <span class="fileinput-exists"> Đổi ảnh </span>
                                                <input class="form-control" type="file" name="image" id="image"
                                                       value="{{get_image_name($blog->image)}}">
                                            </span>
                                            <a href="javascript:;" class="btn default fileinput-exists"
                                               data-dismiss="fileinput"> Xóa ảnh </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Trạng thái
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="is_published" value="1"
                                                   @if($blog->is_published == 1) checked @endif> Công khai
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="is_published" value="0"
                                                   @if($blog->is_published == 0) checked @endif> Riêng tư
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mô tả ngắn <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <div class="">
                                        <textarea name="short_description" rows="5"
                                                  class="form-control">{{$blog->short_description}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Nội dung <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <div class="">
                                        <textarea name="content" class="summernote">{{$blog->content}}</textarea>
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
                           href="{{URL::action('Admin\BlogController@index')}}">
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
    {{Html::script('assets/global/plugins/bootstrap-summernote/summernote.min.js')}}
    {{Html::script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}

    <script>
        $("#title").change(function () {
            if ($("#slug").val() == '') {
                $("#slug").val(convertToSlug($("#title").val()));
            }
        });

        $("#language").change(function () {
            var language = $("#language").val();

            if (language == '') {
                $("#category_id").prop('disabled', true);
            } else {
                $("#category_id").prop('disabled', false);
                $('#category_id').find('option').hide();
                $('#category_id').find('option[data-language="' + language + '"]').show();
            }

            $("#category_id").val('');
        });
    </script>
@endsection