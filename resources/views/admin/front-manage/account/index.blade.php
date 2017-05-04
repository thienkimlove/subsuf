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
            <a href="#">Quản lý Người dùng</a>
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
                        <i class="fa fa-user font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách tài khoản</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        {{Form::open(['action' => 'Admin\AccountController@index', 'method' => 'GET', 'id' => 'search-account-form'])}}
                        <div class="col-md-4">
                            <input type="text" name="full_name" id="full_name" value="{{old('full_name')}}"
                                   class="form-control input-sm clearable" placeholder="Tên...">
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="phone_number" id="phone_number" value="{{old('phone_number')}}"
                                   class="form-control input-sm clearable" placeholder="Điện thoại...">
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" type="text" name="email"
                                           id="email" value="{{old('email')}}" placeholder="Email...">
                                </div>
                                <span class="input-group-btn">
                                    <button id="search_account" class="btn btn-sm btn-success" type="submit">
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
                            <table class="table table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th width="25%">Email</th>
                                    <th width="20%">Tên</th>
                                    <th width="20%">SĐT</th>
                                    <th>Trạng thái</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($accounts as $key => $account)
                                    <tr>
                                        <td align="center">{{$key + 1}}</td>
                                        <td>
                                            <a href="{{URL::action('Admin\AccountController@info', $account->account_id)}}">
                                                {{$account->email}}
                                            </a>
                                            <br>
                                            {{--Trạng thái:--}}
                                            {{--<em class="{{$email_status[$account->is_verified]['class']}}">--}}
                                            {{--{{$email_status[$account->is_verified]['name']}}--}}
                                            {{--</em>--}}
                                        </td>
                                        <td>
                                            {{$account->first_name . ' ' . $account->last_name}}
                                        </td>
                                        <td class="number">
                                            {{substr($account->phone_number, 0 , 3) . ' ' .
                                            substr($account->phone_number, 3 , 3) . ' ' .
                                            substr($account->phone_number, 6)}}
                                        </td>
                                        <td class="{{$account_status[$account->account_status]['class']}}">
                                            {{$account_status[$account->account_status]['name']}}
                                        </td>
                                        <td class="action">
                                            <a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"
                                               href="{{URL::action('Admin\AccountController@info', $account->account_id)}}">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            @if($account->account_status == 1)
                                                <a type="button" class="btn btn-xs red tooltips m-r-0"
                                                   title="Tạm dừng tài khoản"
                                                   onclick="return confirm('Tạm dừng tài khoản {{$account->email}}?');"
                                                   href="{{URL::action('Admin\AccountController@ban', $account->account_id)}}">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            @endif

                                            @if($account->account_status == -1)
                                                <a type="button" class="btn btn-xs green tooltips m-r-0"
                                                   title="Kích hoạt tài khoản"
                                                   onclick="return confirm('Kích hoạt tài khoản {{$account->email}}?');"
                                                   href="{{URL::action('Admin\AccountController@active', $account->account_id)}}">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                                <div class="text-center">{!!  $accounts->appends(Request::except('page'))->links() !!}</div>
                            </table>
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