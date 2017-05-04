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
            <a href="#">Quản lý Admin</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Tài khoản</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase" href="{{URL::action('Admin\AdminController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm tài khoản
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
                        <i class="fa fa-user font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Tài khoản Admin</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th>Tài khoản</th>
                                    <th>Phân quyền</th>
                                    <th>Tên</th>
                                    <th>Trạng thái</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($accounts as $key => $account)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td>
                                            <a href="{{URL::action('Admin\AdminController@info', $account->admin_id)}}">
                                                {{$account->username}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$account->role->name}}
                                        </td>
                                        <td>
                                            {{$account->name}}
                                        </td>
                                        <td align="center">
                                            <span class="{{$account_status[$account->status]['class']}}">
                                                {{$account_status[$account->status]['name']}}
                                            </span>
                                        </td>
                                        <td class="action">
                                            <a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"
                                               href="{{URL::action('Admin\AdminController@info', $account->admin_id)}}">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\AdminController@update', $account->admin_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            @if($account->status == 1)
                                                <a type="button" class="btn btn-xs red tooltips m-r-0"
                                                   title="Tạm dừng tài khoản"
                                                   onclick="return confirm('Tạm dừng tài khoản {{$account->username}}?');"
                                                   href="{{URL::action('Admin\AdminController@ban', $account->admin_id)}}">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            @endif

                                            @if($account->status == -1)
                                                <a type="button" class="btn btn-xs green tooltips m-r-0"
                                                   title="Kích hoạt tài khoản"
                                                   onclick="return confirm('Kích hoạt tài khoản {{$account->username}}?');"
                                                   href="{{URL::action('Admin\AdminController@active', $account->admin_id)}}">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            @endif
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