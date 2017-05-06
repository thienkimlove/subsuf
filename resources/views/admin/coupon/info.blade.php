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
            <a href="{{URL::action('Admin\CouponController@index')}}">Quản lý Coupon</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thông tin: {{$coupon->name}}</span>
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
                        <i class="fa fa-gift font-green"></i>
                        <span class="caption-subject font-green bold uppercase">
                            Coupon: {{$coupon->name}} ({{$coupon->coupon_code}})
                        </span>

                        <span class="caption-subject font-green bold uppercase">
                            Loại :      @if ($coupon->type == 1)
                                Giảm theo <b>{{$coupon->primary_percent}}</b>nhưng không vượt quá {{$coupon->money}}
                            @elseif ($coupon->type == 2)
                                Giảm theo <b>{{$coupon->primary_percent}}</b> nếu tổng tiền (đơn hàng, dịch vụ..) nhỏ hơn hoặc bằng {{$coupon->money}}<br/>
                                Giảm theo <b>{{$coupon->secondary_percent}}</b> nếu tổng tiền (đơn hàng, dịch vụ..) lớn hơn {{$coupon->money}}
                            @else
                                Giảm theo số tiền {{$coupon->money}}
                            @endif
                        </span>

                    </div>
                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang Coupon"
                           href="{{URL::action('Admin\CouponController@index')}}">
                            <i class="fa fa-undo"></i>
                        </a>

                        <a type="button" class="btn btn-xs yellow-gold tooltips m-r-0" title="Sửa"
                           href="{{URL::action('Admin\CouponController@update', $coupon->coupon_id)}}">
                            <i class="fa fa-pencil"></i>
                        </a>

                        <a type="button" class="btn btn-xs red tooltips m-r-0" title="Xóa"
                           onclick="return confirm('Xóa Coupon {{$coupon->name}}?');"
                           href="{{URL::action('Admin\CouponController@delete', $coupon->coupon_id)}}">
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