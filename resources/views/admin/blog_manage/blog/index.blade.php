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
            <span class="bold">Bài viết</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\BlogController@insert')}}">
                <i class="fa fa-pencil-square-o"></i>
                Viết bài
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
                        <i class="fa fa-rss font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Bài viết</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\BlogController@index', 'method' => 'GET', 'id' => 'search-blog'])}}
                    <div class="row" style="margin-bottom: 5px">
                        <div class="col-md-6 col-sm-6">
                            <select name="category" id="category" class="form-control input-sm">
                                <option value="">Thể loại</option>
                                @foreach($blogCategories as $blogCategory)
                                    <option value="{{$blogCategory->category_id}}"
                                            @if($blogCategory->category_id == old('category')) selected @endif>{{$blogCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <select name="author" id="author" class="form-control input-sm">
                                <option value="">Tác giả</option>
                                @foreach($admins as $admin)
                                    <option value="{{$admin->admin_id}}"
                                            @if($admin->admin_id == old('author')) selected @endif>{{$admin->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

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
                                    <input class="form-control input-sm clearable" name="title"
                                           id="title" value="{{old('title')}}" placeholder="Tiêu đề...">
                                </div>
                                <span class="input-group-btn">
                                    <a role="button" class="btn btn-sm default block-button" id="reset">
                                        <i class="fa fa-refresh"></i>
                                        Reset
                                    </a>
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
                                    <th>Tiêu đề</th>
                                    <th>Thể loại</th>
                                    <th>Ngôn ngữ</th>
                                    <th>Tác giả</th>
                                    <th>Thời gian</th>
                                    <th>Chế độ</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blog_list as $key => $blog)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td>
                                            <a href="{{URL::action('Admin\BlogController@update', $blog->blog_id)}}">
                                                {{$blog->title}}
                                            </a>
                                        </td>
                                        <td>{{$blog->category->name}}</td>
                                        <td>{{$blog->language_ref->name}}</td>
                                        <td>{{$blog->author->name}}</td>
                                        <td>{{date('H:i, d-m-Y', strtotime($blog->time_created))}}</td>
                                        <td class="{{$blog_status[$blog->is_published]['class']}}">
                                            {{$blog_status[$blog->is_published]['name']}}
                                        </td>
                                        <td class="text-center">
                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\BlogController@update', $blog->blog_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                                               onclick="return confirm('Xóa Bài viết {{$blog->title}}?');"
                                               href="{{URL::action('Admin\BlogController@delete', $blog->blog_id)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $blog_list->appends(Request::except('page'))->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#reset").click(function () {
            window.location.href = "{{URL::current()}}";
        });
    </script>
@endsection