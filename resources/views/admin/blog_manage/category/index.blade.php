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
            <a href="#">Quản lý Blog</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thể loại</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\BlogCategoryController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm thể loại
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
                        <i class="fa fa-tag font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Thể loại</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\BlogCategoryController@index', 'method' => 'GET', 'id' => 'search-blog-category'])}}
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <select name="language" id="language" class="form-control input-sm">
                                <option value="">Tất cả ngôn ngữ</option>
                                @foreach($languages as $language)
                                    <option value="{{$language->language_code}}"
                                            @if($language->language_code == old('language')) selected @endif>{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" name="name"
                                           id="name" value="{{old('name')}}" placeholder="Thể loại...">
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
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th>Tên Thể loại</th>
                                    <th>Slug</th>
                                    <th class="action">Trạng thái</th>
                                    <th class="action">Ngôn ngữ</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blogCategories as $key => $category)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td>
                                            <a href="{{URL::action('Admin\BlogCategoryController@update', $category->category_id)}}">
                                                {{$category->name}}
                                            </a>
                                        </td>
                                        <td>{{$category->slug}}</td>
                                        <td class="font-{{$category_status[$category->status]['class']}}">
                                            {{$category_status[$category->status]['name']}}
                                        </td>
                                        <td>{{$category->language_ref->name}}</td>
                                        <td class="action">
                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\BlogCategoryController@update', $category->category_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            {{--<a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"--}}
                                            {{--onclick="return confirm('Xóa Thể loại {{$category->name}}?');"--}}
                                            {{--href="{{URL::action('Admin\BlogCategoryController@delete', $category->category_id)}}">--}}
                                            {{--<i class="fa fa-trash"></i>--}}
                                            {{--</a>--}}

                                            @if($category->status)
                                                <a type="button"
                                                   class="btn btn-xs {{$category_status[!$category->status]['class']}} tooltips m-r-0"
                                                   title="{{$category_status[!$category->status]['name']}}"
                                                   href="{{URL::action('Admin\BlogCategoryController@hide', $category->category_id)}}">
                                                    {{$category_status[!$category->status]['name']}}
                                                </a>
                                            @else
                                                <a type="button"
                                                   class="btn btn-xs {{$category_status[!$category->status]['class']}} tooltips m-r-0"
                                                   title="{{$category_status[!$category->status]['name']}}"
                                                   href="{{URL::action('Admin\BlogCategoryController@show', $category->category_id)}}">
                                                    {{$category_status[!$category->status]['name']}}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $blogCategories->appends(Request::except('page'))->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection