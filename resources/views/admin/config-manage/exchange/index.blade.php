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
            <span class="bold">Tỷ giá</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\ExchangeController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm Tỷ giá
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
                        <span class="caption-subject font-green bold uppercase">Danh sách Tỷ giá</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-offset-2 col-md-8">
                            <table class="table table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th>Đơn vị Nguồn</th>
                                    <th>Đơn vị Đích</th>
                                    <th>Trị giá</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exchanges as $key => $exchange)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td>
                                            <a href="{{URL::action('Admin\ExchangeController@update', $exchange->exchange_id)}}">
                                                {{$exchange->from_currency}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{URL::action('Admin\ExchangeController@update', $exchange->exchange_id)}}">
                                                {{$exchange->to_currency}}
                                            </a>
                                        </td>
                                        <td align="right" class="bold">
                                            {{number_format($exchange->money, 2)}}
                                        </td>
                                        <td class="action">
                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\ExchangeController@update', $exchange->exchange_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a type="button" class="btn btn-xs red tooltips m-r-0"
                                               title="Xóa Tỷ giá"
                                               href="{{URL::action('Admin\ExchangeController@delete', $exchange->exchange_id)}}"
                                               onclick="return confirm('Xóa Tỷ giá?');">
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