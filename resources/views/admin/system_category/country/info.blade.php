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
            <a href="{{URL::action('Admin\CountryController@index')}}">Quốc gia</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thông tin: {{$country->name}}</span>
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
                        <i class="fa fa-globe font-green"></i>
                        <span class="caption-subject font-green bold uppercase">
                            Quốc gia: {{$country->name}} ({{$country->country_code}})
                        </span>
                    </div>
                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang Quốc gia"
                           href="{{URL::action('Admin\CountryController@index')}}">
                            <i class="fa fa-undo"></i>
                        </a>

                        <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                           href="{{URL::action('Admin\CountryController@update', $country->country_id)}}">
                            <i class="fa fa-pencil"></i>
                        </a>

                        <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                           onclick="return confirm('Xóa quốc gia {{$country->name}}?');"
                           href="{{URL::action('Admin\CountryController@delete', $country->country_id)}}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="form-body">

                    </div>
                    <div class="form-actions text-right">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection