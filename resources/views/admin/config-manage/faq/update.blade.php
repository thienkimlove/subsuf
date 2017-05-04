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
            <a href="{{URL::action('Admin\FaqController@index')}}">FAQ</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Chi tiết</span>
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
                        <i class="fa fa-question font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Chi tiết</span>
                    </div>

                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang FAQ"
                           href="{{URL::action('Admin\FaqController@index')}}">
                            <i class="fa fa-undo"></i>
                        </a>
                        <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa FAQ này"
                           href="{{URL::action('Admin\FaqController@delete', $faq->faq_id)}}"
                           onclick="return confirm('Xóa FAQ?');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\FaqController@update', $faq->faq_id], 'method' => 'POST', 'id' => 'faq-form',
                    'class'=>'form-horizontal form-bordered','data-toggle'=>'validator', 'enctype'=>'multipart/form-data'])}}
                    <div class="form-body">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-2">
                                Ngôn ngữ <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-md-10">
                                <select name="language" id="language" class="form-control">
                                    @foreach($languages as $language)
                                        <option value="{{$language->language_code}}"
                                                @if($language->language_code == $faq->language) selected @endif>{{$language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-2">
                                Câu hỏi dành cho <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-md-10">
                                <select name="faq_type" id="faq_type" class="form-control">
                                    @foreach($faq_types as $key => $faq_type)
                                        <option value="{{$key}}"
                                                @if($key == $faq->faq_type) selected @endif>{{$faq_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-2">
                                Thứ tự
                            </label>
                            <div class="col-md-10">
                                <input type="number" name="faq_order" value="{{$faq->faq_order}}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-2">
                                Câu hỏi <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-md-10">
                                <textarea name="ask" class="summernote">{{$faq->ask}}</textarea>
                            </div>
                        </div>

                        <div class="form-group form-group-sm last">
                            <label class="control-label col-md-2">
                                Câu trả lời <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-md-10">
                                <textarea name="answer" class="summernote">{{$faq->answer}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-sm green uppercase" id="insert_faq">
                                    Lưu
                                </button>
                                <a role="button" class="btn btn-sm btn-default uppercase"
                                   href="{{URL::action('Admin\FaqController@index')}}">
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