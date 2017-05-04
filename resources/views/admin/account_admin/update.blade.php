@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i> </a>
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
            <span class="bold">Sửa: {{$account['username']}}</span>
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
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user font-green"></i>
                        <span class="caption-subject font-green bold uppercase">
                            Tài khoản: {{$account->username}}
                        </span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\AdminController@update', $account->admin_id], 'method' => 'POST', 'files' => true, 'id' => 'update-admin', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Phân quyền
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select name="role_id" id="role_id" class="form-control">
                                        @foreach($roles as $role)
                                            <option value="{{$role->role_id}}"
                                                    @if ($role->role_id == $account->role->role_id) selected @endif>
                                                {{$role->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Tên đăng nhập
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input readonly type="text" name="username" id="username" class="form-control"
                                           value="{{$account->username}}">
                                </div>

                                <div class="form-group form-group-sm" hidden>
                                    <label class="control-label">Mật khẩu
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="password" name="password" id="password" class="form-control"
                                           value="subsuf123456">
                                </div>

                                <div class="form-group form-group-sm" hidden>
                                    <label class="control-label">Nhập lại mật khẩu
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="password" name="password_confirmation" class="form-control"
                                           id="password_confirmation" value="subsuf123456">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label>Trạng thái</label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="status" id="optionsRadios4" value="1"
                                                   @if($account->status == 1) checked @endif> Kích hoạt
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="status" id="optionsRadios5" value="-1"
                                                   @if($account->status == -1) checked @endif> Tạm dừng
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Họ và tên
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name" id="name" class="form-control"
                                           value="{{$account->name}}">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Tag
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="tag" id="tag" class="form-control"
                                           value="{{$account->tag}}">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Avatar</label>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="@if(isset($account->avatar)) {{$account->avatar}}
                                            @else http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image
                                            @endif" alt="{{get_image_name($account->avatar)}}"/></div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="max-width: 200px; max-height: 150px;">
                                        </div>

                                        <div>
                                            <span class="btn default btn-file">
                                                <span class="fileinput-new"> Chọn ảnh </span>
                                                <span class="fileinput-exists"> Đổi ảnh </span>
                                                <input class="form-control" type="file"
                                                       value="{{get_image_name($account->avatar)}}" name="avatar"
                                                       id="avatar">
                                            </span>
                                            <a href="javascript:;" class="btn default fileinput-exists"
                                               data-dismiss="fileinput"> Xóa ảnh </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions text-right">
                    <button type="submit" class="btn btn-sm green uppercase">
                        Lưu
                    </button>
                    <a role="button" class="btn btn-sm btn-default uppercase"
                       href="{{URL::action('Admin\AdminController@index')}}">
                        Hủy
                    </a>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/pages/scripts/validator.min.js')}}
    {{Html::script('/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
@endsection