@extends('v2.template')


@section('style')
    {{Html::style('assets/global/css/components.min.css')}}
    {{Html::style('assets/global/css/plugins.min.css')}}
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/pages/css/search.min.css')}}
    {{Html::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}
    {{Html::style('assets/global/plugins/icheck/skins/all.css')}}
    {{Html::style('assets/global/plugins/ladda/ladda-themeless.min.css')}}
    {{Html::style('assets/layouts/layout3/css/layout.css')}}
    {{Html::style('assets/layouts/layout3/css/themes/default.min.css')}}
    {{Html::style('assets/layouts/layout3/css/custom.css')}}

@endsection
@section('content')
    @if(!Session::get("userFrontend")["phone_number"]||!Session::get("userFrontend")["email"])

        <div id="updateInfoModal" class="modal fade" tabindex="-1"
             data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{trans("index.capnhatthongtin")}}</h4>
                    </div>
                    {!! Form::open(['action' => 'Frontend\UserController@updateInfo', 'method' => 'POST',"data-toggle"=>"validator"]) !!}
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            {{trans("index.banchuanhapdayduttoffer")}}
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" name="email" value="{{Session::get("userFrontend")["email"]}}"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input class="form-control" name="phone"
                                   value="{{Session::get("userFrontend")["phone_number"]}}"
                                   required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn green">{{trans("index.capnhat")}}</button>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    @endif
    <div class="wrap_container wrap_quytrinhnhanmuaho">
    <div class="container white">
        <div class="row margin-top-40">
            <div class="portlet light">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-8 text-center">
                            <h4>{{trans("index.nhanmuaho")}}</h4>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        @include("frontend.message")
                        {!! Form::open(['action' => ['Frontend\TravelerController@makeOffer',$order->order_id], 'method' => 'POST',"id"=>"offerForm", "data-toggle"=>"validator"]) !!}
                        <div class="col-lg-12">
                            <h4>{{trans("index.sanphamcanmua")}}</h4>

                            <div class="clearfix margin-bottom-10"></div>
                            <div class="form-group">
                                <h4 class="font-red" style="font-weight: 600;">
                                     <span style="float: right" id="totalPrice"
                                           data-total="{{round($order->price*$order->quantity,2)}}">
                                         ${{round($order->price*$order->quantity,2)}}
                                     </span>
                                    <div style="margin-right:80px">
                                        {{$order->name}}
                                    </div>


                                </h4>

                            </div>
                            {{--<div class="form-group">--}}
                            {{--<label>Tiền công</label>--}}
                            {{--<div class="input-group input-medium">--}}
                            {{--<span class="input-group-addon">--}}
                            {{--<input type="checkbox" class="icheck" id="shippingCheck"--}}
                            {{--checked data-checkbox="icheckbox_flat-red">--}}
                            {{--</span>--}}
                            {{--<input type="number" name="shipping_fee" class="form-control"--}}
                            {{--value="{{$order->traveler_reward}}" placeholder="Shipping Fee"></div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label>{{trans("index.tiencongkhonggomthue")}}</label>
                                <div class="input-group input-medium">
                                    <span class="input-group-addon">
                                        <input type="checkbox" class="icheck" id="shippingCheck" checked
                                               data-checkbox="icheckbox_flat-red">
                                    </span>
                                    <input type="number" name="other_fee" class="form-control fee" min="5" step="any"
                                           data-error="{{trans("index.reward_min")}}"
                                           value="{{$order->traveler_reward}}" placeholder="Shipping Fee">
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.thuebotrongneukoco")}}</label>
                                <div class="input-group input-medium">
                                                        <span class="input-group-addon">
                                                           <input name="tax_checkbox" type="checkbox" class="icheck"
                                                                  id="taxCheck" data-checkbox="icheckbox_flat-red">

                                                        </span>
                                    <input type="number" name="tax" class="form-control fee" placeholder="0" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.phivanchuyenbotrongneukoco")}}</label>
                                <div class="input-group input-medium">
                                                        <span class="input-group-addon">
                                                           <input name="other_fee_checkbox" type="checkbox"
                                                                  class="icheck" id="otherCheck"
                                                                  data-checkbox="icheckbox_flat-red" value="0">
                                                        </span>
                                    <input type="number" name="shipping_fee" class="form-control fee"
                                           placeholder="0"
                                           disabled></div>
                            </div>
                            <div class="form-group">
                                <label>{{trans("index.tongtiencongcuoicung")}}</label>


                                <input type="text" id="feeTotal" class="form-control" placeholder="Tổng tiền công"
                                       value="{{$order->traveler_reward}}"
                                       disabled>
                            </div>

                            <div class="form-group" id="deliverFrom">
                                <label>{{trans("index.vanchuyentu")}}</label>
                                {{Form::select("deliver_from",$country,"",["class"=>"form-control select2 select2-single"])}}
                            </div>

                            <div class="form-group">
                                <label>{{trans("index.ngaygiaohang")}}</label>
                                <input class="form-control datepicker" name="date" type="text"
                                       style="padding: 6px 12px;!important;"
                                       value="{{($order->delive_date)?date("d-m-Y",strtotime($order->delive_date)):""}}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label>{{trans("index.note")}}</label>
                                <textarea class="form-control" name="deliver_details" rows="3"
                                          maxlength="200"></textarea>
                            </div>
                            <hr>
                            <h4 class="uppercase">
                                {{trans("index.taikhoan")}}
                            </h4>

                            @if(!$banks&&!$paypals)
                                <div class="alert alert-warning">{{trans("index.banchuacotkgiaodich")}}</div>
                            @else
                                <p>{{trans("index.chontaikhoanbanmuonchuyentien")}}.</p>
                                <div class="form-group">
                                    <label class="mt-radio">
                                        <input type="radio" name="payment_type" value="paypal" required
                                               @if(count($paypals) > 0) checked
                                               @else disabled @endif> {{trans("index.tkpaypal")}}
                                        <span></span>
                                    </label>
                                    @if(count($paypals) > 0)
                                        @foreach($paypals as $paypal)
                                            <div class="" style="margin-left: 50px">
                                                <label class="mt-radio">
                                                    <input type="radio" name="payment_info_id" data-type="paypal"
                                                           value="{{$paypal->payment_info_id}}"> {{$paypal->paypal_email}}
                                                    <span></span>
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-warning">{{trans("index.banchuacotkpaypal")}} </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="mt-radio">
                                        <input type="radio" name="payment_type" value="bank" required
                                               @if(count($banks) > 0) checked
                                               @else disabled @endif>{{trans("index.tknganhangtaivn")}}
                                        <span></span>
                                    </label>
                                </div>
                                @if(count($banks) > 0)
                                    @foreach($banks as $bank)
                                        <div class="" style="margin-left: 50px">
                                            <label class="mt-radio">
                                                <input type="radio" name="payment_info_id" data-type="bank"
                                                       value="{{$bank->payment_info_id}}"> {{$bank->bank_name . ' - ' . $bank->account_number}}
                                                <span></span>
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">{{trans("index.banchuacotknganhang")}}</div>
                                @endif
                            @endif
                            <div class="form-actions text-right">
                                <button type="submit" name="isoffer" value="1" onclick="return checkVerifyEmail()"
                                        class="btn btn-circle green btn-lg mt-ladda-btn ladda-button uppercase"
                                        data-style="expand-right">
                                    {{trans("index.taoyeucau")}}
                                </button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="sendVerifyEmail">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">{{trans("index.guiemailxacnhan")}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="modalAlert">
                            <div class="alert alert-warning">
                                {{trans("index.banchuaxacnhanemail")}}.
                            </div>
                        </div>
                        <div class="text-center">
                            <p>
                                <button type="button" class="close-modal btn btn-outline green" data-dismiss="modal"
                                        aria-label="Close">
                                    {{trans("index.dong")}}
                                </button>
                                <button type="button" onclick="sendVerifyEmail()" class="btn btn-success submit-modal">
                                    {{trans("index.guiemailxacnhan")}}
                                </button>
                            </p>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('frontend_script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/pages/scripts/convert-image-to-base64.js')}}
    {{Html::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}
    {{Html::script('assets/global/plugins/icheck/icheck.min.js')}}
    {{Html::script('assets/pages/scripts/form-icheck.min.js')}}
    {{Html::script('assets/global/plugins/ladda/spin.min.js')}}
    {{Html::script('assets/global/plugins/ladda/ladda.min.js')}}
    {{Html::script('assets/pages/scripts/validator.min.js')}}

    {{Html::script('assets/global/scripts/app.min.js')}}


    <script type="text/javascript">
        function checkVerifyEmail() {
            $.ajax({
                url: "{{URL::action("Frontend\UserController@checkVerifyEmail")}}",
                target: "GET",
                success: function (data) {
                    if (data.status == 1) {
                        $("#offerForm").submit();
                        return true;
                    } else {
                        $("#sendVerifyEmail").modal();
                    }
                }
            });
            return false;
        }
        function sendVerifyEmail() {
            $.ajax({
                url: "{{URL::action("Frontend\UserController@sendVerifyEmail")}}",
                target: "GET",
                beforeSend: function () {
                    $("#sendVerifyEmail .submit-modal").hide();
                    $("#sendVerifyEmail .modalAlert").html('<div class="alert alert-warning">{{trans("index.danggui")}}</div>');
                },
                success: function (data) {
//                    if (data.status == 1) {
                    $("#sendVerifyEmail .modalAlert").html('<div class="alert alert-success">' + data.message + '</div>');
                    $("#sendVerifyEmail .submit-modal").hide();
                    $("#sendVerifyEmail .close-modal").show();
//                    } else {
//                        $("#sendVerifyEmail .modalAlert").html('<div class="alert alert-success">' + data.message + '</div>');
//                    }
                }
            })
        }
        $("#updateInfoModal").modal();
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true
        });
        $('.datepicker').datepicker('setStartDate', new Date());
        $(".icheck").on('ifChecked', function (event) {

            var inputText = $(this).parents(".form-group").find("input[type=number]");
            $(inputText).prop("disabled", false);
            updateTotal();
        });
        $(".icheck").on('ifUnchecked', function (event) {
            var inputText = $(this).parents(".form-group").find("input[type=number]");
            $(inputText).prop("disabled", true);
            $(inputText).val(0);
            updateTotal();
        });
        $("#offerForm input[type=number]").change(function () {
            updateTotal();
        });

        function updateTotal() {
            var total = $("#totalPrice").data("total");
            var fee = 0;

            $("#offerForm input[type=number]").each(function () {
                if ($(this).val()) {
                    fee += parseFloat($(this).val());
                }

            });
            $("#feeTotal").val(fee);
        }

        $(document).ready(function () {
            change_payment();
            change_account();

            $("input[name='payment_type']").change(function () {
                change_payment();
            });

            $("input[name='payment_info_id']").change(function () {
                change_account();
            });
        });

        function change_payment() {
            var payment_type = $("input[name='payment_type']:checked").val();
            $("input[data-type='" + payment_type + "']:first").prop('checked', true);
        }

        function change_account() {
            var checked_account = $("input[name='payment_info_id']:checked");
            var type = checked_account.data('type');
            $("input[name='payment_type'][value='" + type + "']").prop('checked', true);
        }
    </script>
@endsection