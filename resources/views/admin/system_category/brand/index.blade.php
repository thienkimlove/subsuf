@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}
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
            <span class="bold">Thương hiệu</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\BrandController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm Thương hiệu
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
                        <i class="fa fa-amazon font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Thương hiệu</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\BrandController@index', 'method' => 'GET', 'id' => 'brand-search'])}}
                    <div class="row" style="margin-bottom: 5px">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" type="text" name="name"
                                           id="name" value="{{old('name')}}" placeholder="Tìm kiếm Thương hiệu...">
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
                                    <th width="1px">Logo</th>
                                    <th width="1px">Cover</th>
                                    <th>Thương hiệu</th>
                                    <th width="30%">Mô tả</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($brands as $key => $brand)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td align="center" height="40px">
                                            @if($brand->logo != '')
                                                <img src="{{$brand->logo}}" alt=""
                                                     style="max-width: 40px; max-height: 40px">
                                            @else
                                                <i class="fa fa-close"></i>
                                            @endif
                                        </td>

                                        <td align="center" height="40px">
                                            @if($brand->cover != '')
                                                <img src="{{$brand->cover}}" alt=""
                                                     style="max-width: 60px; max-height: 40px">
                                            @else
                                                <i class="fa fa-close"></i>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{URL::action('Admin\BrandController@update', $brand->brand_id)}}">
                                                {{$brand->name}}
                                            </a>

                                            @if($brand->link != '')
                                                <a href="{{$brand->link}}">
                                                    <i class="fa fa-link black tooltips m-r-0"
                                                       title="Đến trang {{$brand->link}}"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{hide_long_text($brand->description)}}</td>
                                        <td class="action">
                                            {{--<a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"--}}
                                            {{--href="{{URL::action('Admin\BrandController@info', $brand->brand_id)}}">--}}
                                            {{--<i class="fa fa-eye"></i>--}}
                                            {{--</a>--}}

                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\BrandController@update', $brand->brand_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                                               onclick="return confirm('Xóa Thương hiệu {{$brand->name}}?');"
                                               href="{{URL::action('Admin\BrandController@delete', $brand->brand_id)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $brands->appends(Request::except('page'))->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}

    <script>
        $("#reset").click(function () {
            window.location.href = "{{URL::current()}}";
        });
    </script>
@endsection