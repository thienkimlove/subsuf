@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}
    {{Html::style('assets/pages/css/profile-2.min.css')}}
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
            <a href="{{URL::action('Admin\AdminController@index')}}">Tài khoản</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thông tin: {{$account->username}}</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')

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
                        <span class="caption-subject font-green bold uppercase">
                            Tài khoản: {{$account->username}}
                        </span>
                    </div>
                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang Tài khoản"
                           href="{{URL::action('Admin\AdminController@index')}}">
                            <i class="fa fa-undo"></i>
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
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-sm-3 profile">
                            <ul class="list-unstyled profile-nav">
                                <li>
                                    <img @if($account->avatar != '') src="{{URL::to($account->avatar)}}"
                                         @else
                                         src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                         @endif
                                         class="img-responsive" alt="">
                                </li>
                            </ul>
                        </div>

                        <div class="col-xs-9">
                            <div class="portlet sale-summary">
                                <div class="portlet-title">
                                    <div class="caption font-green sbold font-16 uppercase">Thông tin</div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="30%">Tên</td>
                                            <td class="bold">{{$account->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Tài khoản</td>
                                            <td class="bold">{{$account->username}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phân quyền</td>
                                            <td class="bold">{{$account->role->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Trạng thái</td>
                                            <td class="bold {{$account_status[$account->status]['class']}}">
                                                {{$account_status[$account->status]['name']}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tag trên blog</td>
                                            <td class="bold">
                                                {{$account->tag}}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
@endsection