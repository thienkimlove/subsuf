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
            <a href="#">Quản lý Blog</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\BlogCategoryController@index')}}">Thể loại</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Sửa: {{$blog_category->name}}</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')

@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-tag font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Thể loại: {{$blog_category->name}}</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\BlogCategoryController@update', $blog_category->category_id], 'method' => 'POST',
                    'id' => 'update-blog-category', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ngôn ngữ
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select required name="language" id="language" class="form-control">
                                        @foreach($languages as $language)
                                            <option value="{{$language['language_code']}}"
                                                    @if($language['language_code'] == $blog_category->language) selected @endif>{{$language['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên Thể loại
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name" value="{{$blog_category->name}}" id="name"
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Slug
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="slug" value="{{$blog_category->slug}}" id="slug"
                                           class="form-control">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label>Hiển thị</label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="status" value="0"
                                                   @if(!$blog_category->status) checked @endif> Ẩn
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="status" value="1"
                                                   @if($blog_category->status) checked @endif> Hiển thị
                                            <span></span>
                                        </label>
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
                           href="{{URL::action('Admin\BlogCategoryController@index')}}">
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

    <script>
        $("#name").change(function () {
            if ($("#slug").val() == '') {
                $("#slug").val(convertToSlug($("#name").val()));
            }
        });
    </script>
@endsection