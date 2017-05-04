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
            <a href="#">Quản lý Danh mục</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\BankController@index')}}">Ngân hàng</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thêm ngân hàng</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')

@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            &nbsp;
        </div>

        <div class="col-md-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-university font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Thêm ngân hàng</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => 'Admin\BankController@insert', 'method' => 'POST', 'id' => 'insert-bank', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Quốc gia
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select required name="country_id" id="country_id" class="form-control">
                                        @foreach($countries as $country)
                                            <option value="{{$country->country_id}}"
                                                    @if(old('country_id') == $country->country_id) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Tên ngân hàng
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input type="text" class="form-control" required name="name" id="name"
                                           value="{{old('name')}}">
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">Swift code
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input type="text" class="form-control" required name="swift_code" id="swift_code"
                                           value="{{old('swift_code')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-sm green uppercase">
                            Lưu
                        </button>
                        <a role="button" class="btn btn-sm btn-default uppercase"
                           href="{{URL::action('Admin\BankController@index')}}">
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