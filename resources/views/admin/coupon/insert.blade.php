@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}
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
            <span class="bold">Thêm Coupon</span>
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
                        <span class="caption-subject font-green bold uppercase">Thêm Coupon</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => 'Admin\CouponController@insert', 'method' => 'POST', 'id' => 'insert-coupon', 'data-toggle'=>'validator'])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Người dùng
                                    </label>
                                    <select name="account_id" id="account_id"
                                            class="form-control input-sm select2-auto">
                                        <option value="0" selected>--- Chọn người dùng ---</option>
                                        @foreach($accounts as $account)
                                            <option value="{{$account->account_id}}"
                                                    @if(old('account_id') == $account->account_id) selected @endif>{{$account->email}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mã Coupon
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="coupon_code" id="coupon_code"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Loại
                                    </label>
                                    <select name="type" id="coupon_type" class="form-control input-sm select2-auto">
                                        @foreach (config('coupon') as $k=>$v)
                                            <option value="{{$k}}" {{($k==0)? 'selected' : ''}}>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        <span id="money_message"></span>
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="number" name="money" id="money" class="form-control">
                                </div>

                                <div id="primary_percent_div" style="display:none" class="form-group form-group-sm">
                                    <label class="control-label">
                                        <span id="primary_message"></span>
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="number" name="primary_percent" id="primary_percent"
                                           class="form-control">
                                </div>

                                <div id="secondary_percent_div" style="display:none" class="form-group form-group-sm">
                                    <label class="control-label">
                                        <span id="secondary_message"></span>
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="number" name="secondary_percent" id="secondary_percent"
                                           class="form-control">
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Số lượng
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="number" name="total" id="money" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Đơn vị tiền
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <select name="currency" id="currency" class="form-control input-sm">

                                        <option value="usd">USD</option>
                                        <option value="vnd">VNĐ</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">Trạng thái</label>
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="status" class="form-control input-sm"
                                                   value="-1" checked=""> Đã dùng
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="status" class="form-control input-sm"
                                                   value="1" checked="checked"> Chưa dùng
                                            <span></span>
                                        </label>
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
                           href="{{URL::action('Admin\CouponController@index')}}">
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
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}
    <script>

        function couponByType() {
            var coupon_type = $('#coupon_type').find("option:selected").val().toString();
            if (coupon_type === '0') {
                $('#primary_message').text('');
                $('#secondary_message').text('');

                $('#primary_percent').val(0).removeAttr('required');
                $('#secondary_percent').val(0).removeAttr('required');

                $('#primary_percent_div').hide();
                $('#secondary_percent_div').hide();
                $('#money_message').text('Giảm một số tiền');
            } else if (coupon_type === '1') {
                $('#primary_message').text('Phần trăm được giảm');
                $('#secondary_message').text('');

                $('#primary_percent').val(0).attr('required', 'true');
                $('#secondary_percent').val(0).removeAttr('required');

                $('#primary_percent_div').show();
                $('#secondary_percent_div').hide();
                $('#money_message').text('Nếu số tiền được giảm không quá');
            } else {
                $('#primary_message').text('Phần trăm được giảm khi số tiền nhỏ hơn hoặc bằng');
                $('#secondary_message').text('Phần trăm được giảm khi số tiền lớn hơn');

                $('#primary_percent').val(0).attr('required', 'true');;
                $('#secondary_percent').val(0).attr('required', 'true');;

                $('#primary_percent_div').show();
                $('#secondary_percent_div').show();


                $('#money_message').text('Số tiền');
            }
        }

        $(function () {
            couponByType();
            $('#money_message').text('Giảm một số tiền');
            $('#coupon_type').on('change', function () {
                couponByType();
                return false;
            });

        })
    </script>
@endsection