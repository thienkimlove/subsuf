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
            <span class="bold">Địa điểm</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\LocationController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm địa điểm
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
                        <i class="fa fa-map-marker font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách địa điểm</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        {{Form::open(['action' => 'Admin\LocationController@index', 'method' => 'GET', 'id' => 'search-location-form'])}}
                        <div class="col-md-6">
                            <select name="type" id="type" class="form-control input-sm">
                                <option value="-1">Loại địa điểm</option>
                                @foreach($type_location as $key => $type)
                                    <option value="{{$key}}" @if($key == old('type')) selected @endif>{{$type}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" type="text" name="location"
                                           id="location" value="{{old('location')}}" placeholder="Tìm kiếm địa điểm...">
                                </div>
                                <span class="input-group-btn">
                                    <button id="search_location" class="btn btn-sm btn-success" type="submit">
                                        Tìm kiếm
                                    </button>
                                </span>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th>Tên</th>
                                    <th class="action">Loại</th>
                                    <th width="100px">Ưu tiên</th>
                                    <th width="100px">Hiển thị</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($locations as $key => $location)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td>
                                            <a href="{{URL::action('Admin\LocationController@update', $location->location_id)}}">
                                                {{$location->name}}
                                            </a>
                                        </td>
                                        <td>{{$type_location[$location->type]}}</td>
                                        <td align="center">{{$location->location_order}}</td>
                                        <td>
                                            @if($location->is_showed)
                                                Có
                                            @else
                                                Không
                                            @endif
                                        </td>
                                        <td class="action">
                                            {{--<a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"--}}
                                            {{--href="{{URL::action('Admin\locationController@info', $location->location_id)}}">--}}
                                            {{--<i class="fa fa-eye"></i>--}}
                                            {{--</a>--}}

                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\LocationController@update', $location->location_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                                               onclick="return confirm('Xóa địa điểm {{$location->name}}?');"
                                               href="{{URL::action('Admin\LocationController@delete', $location->location_id)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $locations->appends(Request::except('page'))->links() !!}</div>
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
    {{Html::script('assets/pages/scripts/admin-custom.js')}}
@endsection