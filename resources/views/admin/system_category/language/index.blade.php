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
            <a href="#">Quản lý Danh mục</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Ngôn ngữ</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\LanguageController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm ngôn ngữ
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
                        <i class="fa fa-language font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách ngôn ngữ</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-1">
                            &nbsp;
                        </div>
                        <div class="col-md-10">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th width="30%">Mã</th>
                                    <th>Tên</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($languages as $key => $language)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td>
                                            {{--<a href="{{URL::action('Admin\LanguageController@info', $language->language_code)}}">--}}
                                            {{$language->language_code}}
                                            {{--</a>--}}
                                        </td>
                                        <td>{{$language->name}}</td>
                                        <td class="action">
                                            {{--<a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"--}}
                                            {{--href="{{URL::action('Admin\LanguageController@info', $language->language_code)}}">--}}
                                            {{--<i class="fa fa-eye"></i>--}}
                                            {{--</a>--}}

                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\LanguageController@update', $language->language_code)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                                               onclick="return confirm('Xóa ngôn ngữ {{$language->name}}?');"
                                               href="{{URL::action('Admin\LanguageController@delete', $language->language_code)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection