@extends('v2.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/pages/css/search.min.css')}}
@endsection
@section('breadcrumb')
@endsection

@section('content')

    <div class="container white">
        <div class="row margin-top-40">
            <div class="portlet light">
                <div class="portlet-body form">

                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-8 text-center">
                            <h4> {{trans("index.vuilongnhapthongtinthanhtoan")}}</h4>
                            <p></p>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        @include("frontend.message")
                        {!! Form::open(['action' => 'Frontend\UserController@updatePaymentInfo', 'method' => 'POST','id'=>'addPlanDetail', 'files' => true,"data-toggle"=>"validator"]) !!}
                        <div class="col-lg-12 margin-top-10">
                            <div id="paymentForm">
                                <h4 class="uppercase">{{trans("index.taikhoannganhang")}}</h4>
                                <div class="clearfix margin-bottom-10"></div>
                                <div class="form-group">
                                    <label>{{trans("index.sotaikhoan")}}</label>
                                    <input class="form-control spinner" name="account_number" type="text"
                                           value="" required="">
                                </div>
                                <div class="form-group">
                                    <label>{{trans("index.tenchutaikhoan")}}</label>
                                    <input class="form-control spinner" name="name" type="text"
                                           placeholder="" required="">
                                </div>
                                {{--<div class="form-group hidden">--}}
                                {{--<label>{{trans("index.quocgia")}}</label>--}}
                                {{--<input class="form-control spinner" name="country_of_bank" type="text"--}}
                                {{--value="Việt Nam" required="">--}}
                                {{--</div>--}}
                                <div class="form-group">
                                    <label>{{trans("index.tennganhangqt")}}</label>
                                    <input class="form-control spinner" name="bank_name" type="text"
                                           value="" required="">
                                </div>
                                <div class="form-group">
                                    <label>{{trans("index.chinhanh")}} </label>
                                    <input class="form-control spinner" name="bank_department" type="text"
                                           value="" required="">
                                </div>
                                {{--<div class="form-group">--}}
                                {{--<label>Swift code </label>--}}
                                {{--<input class="form-control spinner" name="swift_code" type="text"--}}
                                {{--value="" required="">--}}
                                {{--</div>--}}
                            </div>
                            <hr>
                            <div id="paypalForm">
                                <h4 class="uppercase">{{trans("index.hoactkpaypal")}} </h4>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control spinner" name="paypal_email" type="text"
                                           value="" required="">
                                </div>

                                <div class="form-group">
                                    <label>{{trans("index.nhaplaiemail")}} </label>
                                    <input class="form-control spinner" name="paypal_email_confirmation" type="text"
                                           value="" required="">
                                </div>
                            </div>

                            <div class="form-actions text-right">
                                <button type="submit" class="btn btn-circle green btn-lg">{{trans("index.capnhat")}} <i
                                            class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('frontend_script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/pages/scripts/convert-image-to-base64.js')}}

    <script type="text/javascript">
        $("#paymentForm input").change(function () {
            if ($(this).val()) {
                $("#paymentForm input").prop("required", true);
                $("#paypalForm input").prop("required", false);
            }
        });
        $("#paypalForm input").change(function () {
            if ($(this).val()) {
                $("#paymentForm input").prop("required", false);
                $("#paypalForm input").prop("required", true);

            }
        });
        function setImageFile(obj) {
            console.log(1);
            $(obj).parent().find("input[type=file]").click();
        }
        function removeImg(obj) {
            $(obj).parent().remove();
            $("#addImageBtn").data("count", parseInt($("#addImageBtn").data("count")) - 1);
            $("#imageAdd .images-input").show();

        }

    </script>
@endsection