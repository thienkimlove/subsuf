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
            <a href="{{URL::action('Admin\RoleController@index')}}">Phân quyền</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Sửa: {{$role->name}}</span>
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
                        <i class="fa fa-check font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Quyền: {{$role->name}}</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => ['Admin\RoleController@update', $role->role_id], 'method' => 'POST', 'id' => 'role-form', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input type="hidden" name="role_id" value="{{$role->role_id}}">
                                    <input required type="text" name="name" id="name" value="{{$role->name}}"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Quyền hạn</label>
                                    <div class="module-list p-t-10 p-b-10">
                                        @foreach($permissions as $permission)
                                            <?php
                                            $checked = false;
                                            foreach ($role->permissions as $authority) {
                                                if ($authority->module_slug == $permission['module_slug']) {
                                                    $checked = true;
                                                    break;
                                                }
                                            }
                                            ?>
                                            <div class="mt-checkbox-list module-box p-0">
                                                <label class="mt-checkbox mt-checkbox-outline font-bold"> {!! $permission['name'] !!}
                                                    <input type="checkbox" class="cb-module"
                                                           value="{{ $permission['module_slug'] }}"
                                                           name="cb-md-{{ $permission['module_slug'] }}"
                                                           @if($checked) checked @endif>
                                                    <span></span>
                                                </label>
                                                @foreach($permission['functions'] as $function)
                                                    <?php
                                                    $checked_sub = false;
                                                    $read = false;
                                                    $insert = false;
                                                    $update = false;
                                                    $delete = false;
                                                    foreach ($role->permissions as $authority) {
                                                        if ($authority->function_slug == $function['function_slug']) {

                                                            if ($authority->pivot->is_read == 1) $read = true;
                                                            if ($authority->pivot->is_inserted) $insert = true;
                                                            if ($authority->pivot->is_updated) $update = true;
                                                            if ($authority->pivot->is_deleted) $delete = true;
                                                            if ($read || $insert || $update || $delete) $checked_sub = true;
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                    <div class="function-box m-l-25 @if(!$checked) display-hide @endif p-0">
                                                        <label class="mt-checkbox mt-checkbox-outline"> {!! $function['name'] !!}
                                                            <input type="checkbox" class="cb-function"
                                                                   value="{{ $function['function_slug'] }}"
                                                                   name="cb-fn-{{ $function['function_slug'] }}"
                                                                   @if($checked_sub) checked @endif>
                                                            <span></span>
                                                        </label>
                                                        <div class="right-box m-l-25 mt-checkbox-inline p-0 @if(!($checked && $checked_sub)) display-hide @endif>">
                                                            <label class="mt-checkbox">
                                                                <input type="checkbox" value="yes" class="cb-right"
                                                                       name="cb-fn-{{ $function['function_slug'] }}-read"
                                                                       @if($read) checked @endif>
                                                                Xem
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-checkbox">
                                                                <input type="checkbox" value="yes" class="cb-right"
                                                                       name="cb-fn-{{ $function['function_slug'] }}-insert"
                                                                       @if($insert) checked @endif>
                                                                Thêm
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-checkbox">
                                                                <input type="checkbox" value="yes" class="cb-right"
                                                                       name="cb-fn-{{ $function['function_slug'] }}-update"
                                                                       @if($update) checked @endif>
                                                                Sửa
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-checkbox">
                                                                <input type="checkbox" value="yes" class="cb-right"
                                                                       name="cb-fn-{{ $function['function_slug'] }}-delete"
                                                                       @if($delete) checked @endif>
                                                                Xóa
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-sm green uppercase">
                            Lưu
                        </button>
                        <a role="button" href="{{URL::previous()}}" class="btn btn-sm btn-default uppercase">
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
@endsection