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
            <span class="bold">Banners</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    {{--<div class="page-toolbar">--}}
        {{--<div class="pull-right">--}}
            {{--<a type="button" class="btn green btn-sm uppercase"--}}
               {{--href="{{URL::action('Admin\StaticContentController@banner_insert')}}">--}}
                {{--<i class="fa fa-plus"></i>--}}
                {{--Thêm--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-info font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-1">
                            &nbsp;
                        </div>
                        <div class="col-md-10">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th>Hình ảnh</th>
                                    <th>Ngôn ngữ</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($banners as $key => $banner)
                                    <tr>
                                        <td class="stt">{{$banner->order}}</td>
                                        <td><img src="{{$banner->image}}" style="max-width: 1000px"></td>
                                        <td>{{$banner->language}}</td>
                                        <td class="action">
                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\StaticContentController@banner_update', $banner->id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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

@endsection