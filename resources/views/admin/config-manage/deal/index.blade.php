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
            <span class="bold">Popup Khuyến mãi</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\DealController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm Popup
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
                        <i class="fa fa-exchange font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Popup</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <table class="table table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th>Tiêu đề</th>
                                    <th>Mô tả</th>
                                    <th>Ảnh</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deals as $key => $deal)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td>
                                            <a href="{{URL::action('Admin\DealController@update', $deal->id)}}">
                                                {{$deal->title}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{URL::action('Admin\DealController@update', $deal->id)}}">
                                                {{$deal->desc}}
                                            </a>
                                        </td>
                                        <td align="right" class="bold">
                                            <img src="{{$deal->image}}">
                                        </td>
                                        <td class="action">
                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\DealController@update', $deal->id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a type="button" class="btn btn-xs red tooltips m-r-0"
                                               title="Xóa Tỷ giá"
                                               href="{{URL::action('Admin\DealController@delete', $deal->id)}}"
                                               onclick="return confirm('Xóa?');">
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