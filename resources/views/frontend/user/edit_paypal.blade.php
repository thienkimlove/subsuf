<div class="portlet box green" style="margin-bottom: 0px !important;">
    <div class="portlet-title">
        <div class="caption text-uppercase">
            {{$title}}
        </div>
    </div>

    <div class="portlet-body">
        {!! Form::open(['action' => ['Frontend\UserController@edit_paypal', $payment->payment_info_id], 'method' => 'POST', 'id' => 'paypal_form']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control spinner" name="paypal_email" type="text"
                               value="{{$payment->paypal_email}}" required="required">
                    </div>

                    <div class="form-group">
                        <label>{{trans("index.nhaplaiemail")}} </label>
                        <input class="form-control spinner" name="paypal_email_confirmation" type="text"
                               value="{{$payment->paypal_email}}" required="required">
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