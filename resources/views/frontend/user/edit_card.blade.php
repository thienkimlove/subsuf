<div class="portlet box green" style="margin-bottom: 0px !important;">
    <div class="portlet-title">
        <div class="caption text-uppercase">
            {{$title}}
        </div>
    </div>

    <div class="portlet-body">
        {!! Form::open(['action' => ['Frontend\UserController@edit_card', $payment->payment_info_id], 'method' => 'POST', 'id' => 'atm_form']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{trans("index.sotaikhoan")}}
                            <span class="required" aria-required="true">(*)</span>
                        </label>
                        <input class="form-control spinner" name="account_number" type="text"
                               value="{{$payment->account_number}}" required="required">
                    </div>
                    <div class="form-group">
                        <label>{{trans("index.tenchutaikhoan")}}
                            <span class="required" aria-required="true">(*)</span>
                        </label>
                        <input class="form-control spinner" name="name" type="text" value="{{$payment->name}}"
                               placeholder="" required="required">
                    </div>
                    {{--<div class="form-group">--}}
                    {{--<label>{{trans("index.quocgia")}}--}}
                    {{--<span class="required" aria-required="true">(*)</span>--}}
                    {{--</label>--}}
                    {{--<input class="form-control spinner" name="country_of_bank" type="text"--}}
                    {{--value="{{$payment->country_of_bank}}" required="required">--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label>{{trans("index.tennganhangqt")}}
                            <span class="required" aria-required="true">(*)</span>
                        </label>
                        <input class="form-control spinner" name="bank_name" type="text"
                               value="{{$payment->bank_name}}" required="required">
                    </div>
                    <div class="form-group">
                        <label>{{trans("index.chinhanh")}}
                            <span class="required" aria-required="true">(*)</span>
                        </label>
                        <input class="form-control spinner" name="bank_department" type="text"
                               value="{{$payment->bank_department}}" required="required">
                    </div>
                    {{--<div class="form-group">--}}
                    {{--<label>Swift code--}}
                    {{--<span class="required" aria-required="true">(*)</span>--}}
                    {{--</label>--}}
                    {{--<input class="form-control spinner" name="swift_code" type="text"--}}
                    {{--value="{{$payment->swift_code}}" required="required">--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label class="font-red bold"><span class="required" aria-required="true">(*)</span>
                            {{trans("index.required_fields")}}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions text-right">
            <button type="submit" class="btn green text-uppercase"><i
                        class="fa fa-floppy-o"></i> {{trans("index.capnhat")}}
            </button>
            <button type="reset" data-dismiss="modal"
                    class="btn btn-default text-uppercase">{{trans("index.dong")}}</button>
        </div>
        {{! Form::close()}}
    </div>
</div>