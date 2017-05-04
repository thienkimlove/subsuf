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
            <span class="bold">Thêm quyền</span>
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
                        <span class="caption-subject font-green bold uppercase">Thêm quyền</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => 'Admin\RoleController@insert', 'method' => 'POST', 'id' => 'role-form', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Quyền hạn</label>
                                    <div class="module-list p-t-10 p-b-10">
                                        @foreach($permissions as $permission)
                                            <div class="mt-checkbox-list module-box p-0">
                                                <label class="mt-checkbox mt-checkbox-outline font-bold"> {{ $permission['name'] }}
                                                    <input type="checkbox" class="cb-module"
                                                           value="{{ $permission['module_slug'] }}"
                                                           name="cb-md-{{ $permission['module_slug'] }}">
                                                    <span></span>
                                                </label>
                                                @foreach($permission['functions'] as $function)
                                                    <div class="function-box m-l-25 display-hide p-0">
                                                        <label class="mt-checkbox mt-checkbox-outline"> {!! $function['name'] !!}
                                                            <input type="checkbox" class="cb-function"
                                                                   value="{{ $function['function_slug'] }}"
                                                                   name="cb-fn-{{ $function['function_slug'] }}">
                                                            <span></span>
                                                        </label>
                                                        <div class="right-box m-l-25 mt-checkbox-inline p-0 display-hide">
                                                            <label class="mt-checkbox">
                                                                <input type="checkbox" value="yes" class="cb-right"
                                                                       name="cb-fn-{{ $function['function_slug'] }}-read">
                                                                Xem
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-checkbox">
                                                                <input type="checkbox" value="yes" class="cb-right"
                                                                       name="cb-fn-{{ $function['function_slug'] }}-insert">
                                                                Thêm
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-checkbox">
                                                                <input type="checkbox" value="yes" class="cb-right"
                                                                       name="cb-fn-{{ $function['function_slug'] }}-update">
                                                                Sửa
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-checkbox">
                                                                <input type="checkbox" value="yes" class="cb-right"
                                                                       name="cb-fn-{{ $function['function_slug'] }}-delete">
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
                        <a role="button" class="btn btn-sm btn-default uppercase"
                           href="{{URL::action('Admin\RoleController@index')}}">
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