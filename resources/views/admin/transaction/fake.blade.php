@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}

@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i> </a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{URL::action('Admin\TransactionController@index')}}">Giao dich</a>
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
                        <span class="caption-subject font-green bold uppercase">Fake giao dịch</span>
                    </div>
                </div>

                <div class="portlet-body form">
                    {{Form::open(['action' => 'Admin\TransactionController@doFakeTransaction', 'method' => 'POST', 'id' => 'insert-coupon', 'data-toggle'=>'validator','files' => true])}}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Người order
                                    </label>
                                    <select name="shopper_id" id="account_id"
                                            class="form-control input-sm select2-auto" required>
                                        <option value="0" selected>--- Chọn người order ---</option>
                                        @foreach($accounts as $account)
                                            <option value="{{$account->account_id}}"
                                                    @if(old('account_id') == $account->account_id) selected @endif>{{$account->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ngày nhận hàng dự kiến
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="tex" name="deliver_date" id="money"
                                           class="date-picker form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Nơi mua hàng dự kiến
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    {{Form::select("deliver_from",$country,"",["class"=>"form-control select2"])}}
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Nơi nhận hàng
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    {{Form::select("deliver_to",$province,"",["id"=>"deliverTo","class"=>"form-control select21","required"=>"required"])}}
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ảnh sản phẩm
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="file" name="image" class="form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Link sản phẩm
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="link" class="form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tên sản phẩm
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Mô tả
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <textarea class="form-control" name="description" rows="3"
                                              placeholder="Màu sắc, kích cỡ, model..." required=""
                                              maxlength="200"></textarea>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Giá
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="price" class="form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Số lượng
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="quantity" class="form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tiền công cho traveler dự kiến (shopper đặt)
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="traveler_reward" class="form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ngày shopper đồng ý y/cầu mua hàng
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="transaction_date"
                                           class="date-picker form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Ngày nhận hàng thực tế
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="received_time" class="date-picker form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Người du lịch
                                    </label>
                                    <select name="traveler_id" id="account_id"
                                            class="form-control input-sm select2-auto" required>
                                        <option value="0" selected>--- Chọn người du lịch ---</option>
                                        @foreach($accounts as $account)
                                            <option value="{{$account->account_id}}"
                                                    @if(old('account_id') == $account->account_id) selected @endif>{{$account->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Nơi mua hàng
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    {{Form::select("deliver_from_traveler",$country,"",["class"=>"form-control select2"])}}
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Shipping fee
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="shipping_fee" class="form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Thuế
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="tax" class="form-control">
                                </div>
                                <div class="form-group form-group-sm">
                                    <label class="control-label">
                                        Tiền công
                                        <span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input required type="text" name="others_fee" class="form-control">
                                </div>

                            </div>

                            <div class="col-md-6">

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
    {{Html::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}

@endsection