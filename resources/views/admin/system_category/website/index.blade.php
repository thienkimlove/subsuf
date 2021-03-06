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
            <span class="bold">Website</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\WebsiteController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm Website
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
                        <i class="fa fa-chrome font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Website</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\WebsiteController@index', 'method' => 'GET', 'id' => 'website-search'])}}
                    <div class="row" style="margin-bottom: 5px">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" type="text" name="name"
                                           id="name" value="{{old('name')}}" placeholder="Tìm kiếm trang web...">
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

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group form-group-sm" style="margin-bottom: 0">
                                <select name="location_id" id="location_id" class="form-control input-sm select2-auto">
                                    <option value="" selected>--- Quốc gia ---</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->location_id}}"
                                                @if(old('location_id') == $location->location_id) selected @endif>{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group form-group-sm" style="margin-bottom: 0">
                                <select name="category_id" id="category_id" class="form-control input-sm select2-auto">
                                    <option value="" selected>--- Nhóm hàng hóa ---</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->category_id}}"
                                                @if(old('category_id') == $category->category_id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
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
                                    <th>Website</th>
                                    <th width="100px">Quốc gia</th>
                                    <th width="100px">Nhóm hàng</th>
                                    <th width="100px">Ưu tiên</th>
                                    <th width="100px">Hiển thị</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($websites as $key => $website)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td align="center" height="40px">
                                            @if($website->image != '')
                                                <img src="{{$website->image}}" alt=""
                                                     style="max-width: 40px; max-height: 40px">
                                            @else
                                                <i class="fa fa-chrome"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{URL::action('Admin\WebsiteController@update', $website->website_id)}}">
                                                {{$website->name}}
                                            </a>

                                            <a href="{{$website->link}}">
                                                <i class="fa fa-link black tooltips m-r-0"
                                                   title="Đến trang {{$website->name}}"></i>
                                            </a>

                                            @if($website->description)
                                                - {{$website->description}}
                                            @endif
                                        </td>
                                        <td>{{isset($website->nation) ? $website->nation->name : ''}}</td>
                                        <td>{{isset($website->category) ? $website->category->name : ''}}</td>
                                        <td align="center">{{$website->website_order}}</td>
                                        <td>
                                            @if($website->is_showed)
                                                Có
                                            @else
                                                Không
                                            @endif
                                        </td>
                                        <td class="action">
                                            {{--<a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"--}}
                                            {{--href="{{URL::action('Admin\WebsiteController@info', $website->website_id)}}">--}}
                                            {{--<i class="fa fa-eye"></i>--}}
                                            {{--</a>--}}

                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\WebsiteController@update', $website->website_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                                               onclick="return confirm('Xóa Website {{$website->name}}?');"
                                               href="{{URL::action('Admin\WebsiteController@delete', $website->website_id)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $websites->appends(Request::except('page'))->links() !!}</div>
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