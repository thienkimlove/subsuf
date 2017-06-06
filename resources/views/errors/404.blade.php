@extends('v2.template')
@section('style')

    <style type="text/css">
        #orderDetail h2 {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #69717e;
        }

        .content-right {
            font-size: 14px;
            float: right;
            text-transform: none;
        }

        #orderDetail .col-xs-12 h2 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
    </style>
@endsection
@section('breadcrumb')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 margin-top-40">
                <div style="padding: 30px 15px; background: #fff" class="text-center">
                    <h1 class="font-red" style="font-size: 80px; font-weight: 400">404</h1>
                    <p>Rất tiếc! chúng tôi không tìm thấy trang mà bạn yêu cầu!</p>
                    <p><a href="/" class="btn red">Quay lại trang chủ</a> </p>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/pages/scripts/convert-image-to-base64.js')}}

    <script type="text/javascript">
        function addCoupon(counpon, id) {
            $("#couponAdded").show();
            $("#addCoupon").hide();
            $("#couponAdded .couponValue").html(
                    "$" + counpon +
                    '<input type="hidden" name="coupon" value="' + id + '">'
            );
            $("#resetCoupon").show();
            $("#couponModal .alert").hide();
        }
        function addNewCoupon() {
            $("#couponModal .alert").show();
        }
        function removeCoupon() {
            $("#addCoupon").show();
            $("#couponAdded").hide();
            $("#resetCoupon").hide();
            $("#couponAdded .couponValue").html("");
        }
    </script>
@endsection