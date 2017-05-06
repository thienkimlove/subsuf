@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Quản lý Coupon</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase"
               href="{{URL::action('Admin\CouponController@insert')}}">
                <i class="fa fa-plus"></i>
                Thêm Coupon
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
                        <i class="fa fa-gift font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Coupon</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\CouponController@index', 'method' => 'GET', 'id' => 'search-coupon-form'])}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-sm" style="margin-bottom: 0">
                                <select name="account_id" id="account_id" class="form-control input-sm select2-auto">
                                    <option value="" selected>--- Người dùng ---</option>
                                    @foreach($accounts as $account)
                                        <option value="{{$account->account_id}}"
                                                @if(old('account_id') == $account->account_id) selected @endif>{{$account->email}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-group-sm" style="margin-bottom: 0">
                                <select name="status" id="status" class="form-control input-sm select2-auto">
                                    <option value="" selected>--- Trạng thái ---</option>
                                    @foreach($coupon_status as $key => $status)
                                        <option value="{{$key}}"
                                                @if(old('status') == $key) selected @endif>{{$status['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" type="text" name="coupon_code"
                                           id="coupon_code" value="{{old('coupon_code')}}"
                                           placeholder="Tìm kiếm Coupon...">
                                </div>
                                <span class="input-group-btn">
                                    <button id="search_coupon" class="btn btn-sm btn-success" type="submit">
                                        Tìm kiếm
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th>Mã</th>
                                    <th>Mô Tả</th>
                                    <th>Người dùng</th>
                                    <th width="100px">Số lượng</th>
                                    <th width="100px">Còn lại</th>
                                    {{--<th width="100px">Ngày dùng</th>--}}
                                    <th width="100px">Trạng thái</th>
                                    <th class="action">Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($coupons as $key => $coupon)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>

                                        <td>
                                            <a href="{{URL::action('Admin\CouponController@update', $coupon->coupon_id)}}">
                                                {{$coupon->coupon_code}}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($coupon->type == 1)
                                                Giảm theo <b>{{$coupon->primary_percent}}%</b> nhưng không vượt quá <b>${{$coupon->money}}</b>
                                            @elseif ($coupon->type == 2)
                                                Giảm theo <b>{{$coupon->primary_percent}}%</b> nếu tổng tiền (đơn hàng, dịch vụ..) nhỏ hơn hoặc bằng <b>${{$coupon->money}}</b><br/>
                                                Giảm theo <b>{{$coupon->secondary_percent}}%</b> nếu tổng tiền (đơn hàng, dịch vụ..) lớn hơn <b>${{$coupon->money}}</b>
                                            @else
                                                Giảm theo số tiền <b>${{$coupon->money}}</b>
                                            @endif
                                        </td>
                                        <td>{{isset($coupon->account) ? $coupon->account->email : ''}}</td>

                                        <td class="text-right">{{$coupon->total}}</td>
                                        <td class="text-right">{{$coupon->amount}}</td>
                                        {{--<td class="text-right">--}}
                                            {{--@if($coupon->used_at != '')--}}
                                                {{--{{date('d-m-Y', strtotime($coupon->used_at))}}--}}
                                            {{--@endif--}}
                                        {{--</td>--}}
                                        <td align="center" class="{{$coupon_status[$coupon->status]['class']}}">
                                            {{$coupon_status[$coupon->status]['name']}}
                                        </td>
                                        <td class="action">
                                            {{--<a type="button" class="btn btn-xs btn-primary tooltips m-r-0" title="Xem"--}}
                                            {{--href="{{URL::action('Admin\CouponController@info', $coupon->coupon_id)}}">--}}
                                            {{--<i class="fa fa-eye"></i>--}}
                                            {{--</a>--}}
                                            <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                                               href="{{URL::action('Admin\CouponController@update', $coupon->coupon_id)}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                                               onclick="return confirm('Xóa Coupon {{$coupon->name}}?');"
                                               href="{{URL::action('Admin\CouponController@delete', $coupon->coupon_id)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $coupons->appends(Request::except('page'))->links() !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/pages/scripts/admin-custom.js')}}
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}
@endsection