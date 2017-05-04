@extends('admin.layout.master')
@section('style')
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
            <span class="bold">FAQ</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\FaqController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm FAQ
            </a>
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
                        <i class="fa fa-question font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách FAQ</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\FaqController@index', 'method' => 'GET', 'id' => 'search-faq'])}}
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select name="faq_type" id="faq_type" class="form-control input-sm">
                                <option value="">Tất cả câu hỏi</option>
                                @foreach($faq_types as $key => $faq_type)
                                    <option value="{{$key}}"
                                            @if($key == old('faq_type')) selected @endif>{{$faq_type}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <select name="language" id="language" class="form-control input-sm">
                                <option value="">Tất cả ngôn ngữ</option>
                                @foreach($languages as $language)
                                    <option value="{{$language->language_code}}"
                                            @if($language->language_code == old('language')) selected @endif>{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" name="ask"
                                           id="ask" value="{{old('ask')}}" placeholder="Câu hỏi...">
                                </div>
                                <span class="input-group-btn">
                                    <button id="search_order" class="btn btn-sm btn-success block-button" type="submit">
                                        <i class="fa fa-search"></i>
                                        Tìm kiếm
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th>Câu hỏi</th>
                                    <th>Dành cho</th>
                                    <th>Ưu tiên</th>
                                    <th>Ngôn ngữ</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($faqs as $key => $faq)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td>
                                            <a href="{{URL::action('Admin\FaqController@update', $faq->faq_id)}}">
                                                {{strip_tags($faq->ask)}}
                                            </a>
                                        </td>
                                        <td>{{$faq_types[$faq->faq_type]}}</td>
                                        <td align="center">{{$faq->faq_order}}</td>
                                        <td>{{$faq->language_ref->name}}</td>
                                        <td class="action">
                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\FaqController@update', $faq->faq_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa FAQ này"
                                               href="{{URL::action('Admin\FaqController@delete', $faq->faq_id)}}"
                                               onclick="return confirm('Xóa FAQ?');">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection