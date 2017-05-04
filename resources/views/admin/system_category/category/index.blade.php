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
            <a href="#">Quản lý Danh mục</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Nhóm hàng hóa</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\CategoryController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm nhóm hàng hóa
            </a>
        </div>
    </div>
@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-barcode font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Nhóm hàng</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\CategoryController@index', 'method' => 'GET', 'id' => 'category-search'])}}
                    <div class="row">
                        <div class="col-md-6">
                            <select name="category_type" id="category_type" class="form-control input-sm">
                                <option value="">--- Phân nhóm ---</option>
                                @foreach($category_types as $key => $type)
                                    <option value="{{$key}}"
                                            @if($key == old('category_type')) selected @endif>{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" type="text" name="name"
                                           id="name" value="{{old('name')}}" placeholder="Tìm kiếm Nhóm hàng hóa...">
                                </div>
                                <span class="input-group-btn">
                                    <a role="button" class="btn btn-sm default block-button" id="reset">
                                        <i class="fa fa-refresh"></i>
                                        Reset
                                    </a>
                                    <button id="search_location" class="btn btn-sm btn-success" type="submit">
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
                                    <th class="stt">Ảnh</th>
                                    <th>Nhóm hàng</th>
                                    <th width="100px">Thuộc nhóm</th>
                                    <th width="100px">Ưu tiên</th>
                                    <th width="100px">Hiển thị</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $key => $category)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td class="fit" align="center" height="30px">
                                            @if($category->image != '')
                                                <img src="{{$category->image}}" alt=""
                                                     style="max-width: 30px; max-height: 30px">
                                            @else
                                                <i class="fa fa-chrome"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{URL::action('Admin\CategoryController@update', $category->category_id)}}">
                                                {{$category->name}}
                                            </a>
                                        </td>
                                        <td>{{$category_types[$category->category_type]}}</td>
                                        <td align="center">{{$category->category_order}}</td>
                                        <td>
                                            @if($category->is_showed)
                                                Có
                                            @else
                                                Không
                                            @endif
                                        </td>
                                        <td class="action">
                                            {{--<a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"--}}
                                            {{--href="{{URL::action('Admin\CategoryController@info', $category->category_id)}}">--}}
                                            {{--<i class="fa fa-eye"></i>--}}
                                            {{--</a>--}}

                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\CategoryController@update', $category->category_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                                               onclick="return confirm('Xóa Nhóm hàng hóa {{$category->name}}?');"
                                               href="{{URL::action('Admin\CategoryController@delete', $category->category_id)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $categories->appends(Request::except('page'))->links() !!}</div>
                        </div>
                        <div class="col-md-1">
                            &nbsp;
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