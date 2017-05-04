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
            <span class="bold">Ngân hàng</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\BankController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm ngân hàng
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
                        <i class="fa fa-university font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách ngân hàng</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        {{Form::open(['action' => 'Admin\BankController@index', 'method' => 'GET', 'id' => 'search-bank-form'])}}

                        <div class="col-md-6">
                            <select name="country_id" id="country_id" class="form-control input-sm">
                                <option value="">Tất cả quốc gia</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->country_id}}"
                                            @if(old('country_id') == $country->country_id) selected @endif>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" type="text" name="bank"
                                           id="bank" value="{{old('bank')}}" placeholder="Tên ngân hàng...">
                                </div>
                                <span class="input-group-btn">
                                    <button id="search_bank" class="btn btn-sm btn-success" type="submit">
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
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th width="30%">Ngân hàng</th>
                                    <th>Swift Code</th>
                                    <th width="30%">Quốc gia</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($banks as $key => $bank)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td>
                                            {{--<a href="{{URL::action('Admin\BankController@info', $bank->bank_id)}}">--}}
                                            {{$bank->name}}
                                            {{--</a>--}}
                                        </td>
                                        <td>{{$bank->swift_code}}</td>
                                        <td>{{$bank->country->name}}</td>
                                        <td class="action">
                                            {{--<a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"--}}
                                            {{--href="{{URL::action('Admin\BankController@info', $bank->bank_id)}}">--}}
                                            {{--<i class="fa fa-eye"></i>--}}
                                            {{--</a>--}}

                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\BankController@update', $bank->bank_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                                               onclick="return confirm('Xóa ngân hàng {{$bank->name}}?');"
                                               href="{{URL::action('Admin\BankController@delete', $bank->bank_id)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $banks->appends(Request::except('page'))->links() !!}</div>
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