@extends('admin.layout.master')
@section('style')
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
            <span class="bold">Đổi mật khẩu</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')

@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-key font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Đổi mật khẩu</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {!! Form::open(["action"=>'Admin\AdminController@change_password',
                    "method" => "POST", "data-toggle" => "validator", 'id' => 'change-password']) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">
                                    <label for="inputPassword" class="control-label">Mật khẩu cũ</label>
                                    <input type="password" name="old_password" class="form-control"
                                           placeholder="Mật khẩu cũ"
                                           required>
                                    <div class="help-block"></div>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputPassword" class="control-label">Mật khẩu mới</label>
                                    <input type="password" name="password" data-minlength="6" class="form-control"
                                           id="inputPassword" placeholder="Mật khẩu mới" required>
                                    <div class="help-block font-12">Mật khẩu từ 6 đến 32 ký tự</div>

                                </div>
                                <div class="form-group form-group-sm">
                                    <label for="inputPassword" class="control-label">Nhập lại mật khẩu mới</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           id="inputPasswordConfirm" placeholder="Nhập lại mật khẩu" required
                                           data-match="#inputPassword" data-match-error="Mật khẩu nhập lại không đúng">
                                    <div class="help-block with-errors font-12"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-sm green uppercase">
                            Lưu mật khẩu
                        </button>
                        <a role="button" class="btn btn-sm btn-default uppercase"
                           href="{{URL::previous()}}">
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
    {{--{{Html::script('assets/pages/scripts/validator.min.js')}}--}}
@endsection