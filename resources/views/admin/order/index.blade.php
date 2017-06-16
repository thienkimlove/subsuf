@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}

    {{Html::style('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}

    {{Html::style('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}
    {{Html::style('assets/global/plugins/morris/morris.css')}}
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Quản lý Order</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <div id="dashboard-report-range" class="tooltips btn btn-sm green input-sm"
                 data-original-title="Chọn thời gian">
                <i class="icon-calendar"></i>&nbsp;
                <span class="uppercase"></span>&nbsp;
                <i class="fa fa-angle-down"></i>
            </div>
        </div>
    </div>
@endsection

@section('pagetitle')

@endsection

@section('content')
    <h1 class="page-title">
    </h1>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-green-sharp">
                            <span data-counter="counterup" data-value="7800">
                                {{$statistics['money']['valuable']}}
                            </span>
                            <small class="font-green-sharp">$</small>
                        </h3>
                        <small>GIÁ TRỊ</small>
                    </div>
                    <div class="icon">
                        <i class="icon-pie-chart"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: {{$statistics['percent']['money']}}%;"
                              class="progress-bar progress-bar-success green-sharp">
                            <span class="sr-only">76% progress</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"> Tổng</div>
                        <div class="status-number"> {{$statistics['percent']['money']}}%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-red-haze">
                            <span data-counter="counterup" data-value="1349">
                                {{$statistics['order']['total']}}
                            </span>
                        </h3>
                        <small>Đơn hàng</small>
                    </div>
                    <div class="icon">
                        <i class="icon-basket"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: 100%;" class="progress-bar progress-bar-success red-haze">
                            <span class="sr-only">100% tổng</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"> Tổng</div>
                        <div class="status-number"> 100%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-blue-sharp">
                            <span data-counter="counterup" data-value="567">
                                {{$statistics['order']['new']}}
                            </span>
                        </h3>
                        <small>ĐH mới</small>
                    </div>
                    <div class="icon">
                        <i class="icon-basket"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: {{$statistics['percent']['new']}}%;"
                              class="progress-bar progress-bar-success blue-sharp">
                            <span class="sr-only">45% tăng</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"></div>
                        <div class="status-number"> {{$statistics['percent']['new']}}%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-purple-soft">
                            <span data-counter="counterup" data-value="276">
                                {{$statistics['order']['out']}}
                            </span>
                        </h3>
                        <small>ĐH Quá hạn</small>
                    </div>
                    <div class="icon">
                        <i class="icon-basket"></i>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: {{$statistics['percent']['out']}}%;"
                              class="progress-bar progress-bar-success purple-soft">
                            <span class="sr-only">56% change</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"></div>
                        <div class="status-number"> {{$statistics['percent']['out']}}%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered block-div">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Order</span>
                    </div>
                </div>

                <br>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\OrderController@index', 'method' => 'GET', 'id' => 'order-search'])}}
                    <div class="row" style="margin-bottom: 5px">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    {{--<input class="form-control input-sm clearable" type="number" name="order_id"--}}
                                           {{--id="order_id" value="{{old('order_id')}}" placeholder="Mã Order...">--}}

                                    <input class="form-control input-sm clearable" type="number" name="code"
                                           id="code" value="{{old('code')}}" placeholder="Mã Order...">
                                </div>
                                <span class="input-group-btn">
                                    <a role="button" class="btn btn-sm default block-button" id="reset">
                                        <i class="fa fa-refresh"></i>
                                        Reset
                                    </a>
                                    <button id="search_order" class="btn btn-sm btn-success block-button" type="submit">
                                        <i class="fa fa-search"></i>
                                        Tìm kiếm
                                    </button>
                                    <a role="button" id="advance" class="btn btn-sm">
                                        Tìm kiếm nâng cao <i class="fa fa-caret-right"></i>
                                    </a>
                                    <input type="hidden" id="is_advance" name="is_advance" value="{{$is_advance}}">
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row row-advance" style="margin-bottom: 5px">
                        <div class="col-md-4">
                            <div class="form-group form-group-sm" style="margin-bottom: 0">
                                <select name="deliver_from" id="deliver_from" disabled
                                        class="form-control input-sm select2-auto">
                                    <option value="-1" selected>--- Nơi chuyển ---</option>
                                    @foreach($from_location as $from)
                                        <option value="{{$from->location_id}}"
                                                @if(old('deliver_from') == $from->location_id) selected @endif>{{$from->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group form-group-sm" style="margin-bottom: 0">
                                <select name="deliver_to" id="deliver_to" class="form-control input-sm select2-auto"
                                        disabled>
                                    <option value="-1" selected>--- Nơi nhận ---</option>
                                    @foreach($to_location as $to)
                                        <option value="{{$to->location_id}}"
                                                @if(old('deliver_to') == $to->location_id) selected @endif>{{$to->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="deliver_date" id="deliver_date" disabled placeholder="Ngày chuyển"
                                   class="form-control input-sm date-picker clearable" value="{{old('deliver_date')}}">
                        </div>
                    </div>

                    <div class="row row-advance">
                        <div class="col-md-4">
                            <select name="order_status" id="order_status" class="form-control input-sm" disabled>
                                <option value="-100" selected>--- Trạng thái Order ---</option>
                                @foreach($order_status as $key => $status)
                                    <option value="{{$key}}"
                                            @if(old('order_status') == $key) selected @endif>{{$status['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="link" id="link" class="form-control input-sm clearable" disabled
                                   placeholder="Website" value="{{old('link')}}">
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="email" id="email" class="form-control input-sm clearable" disabled
                                   placeholder="Email" value="{{old('email')}}">
                        </div>
                    </div>
                    {{Form::close()}}

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="stt">STT</th>
                                        <th class="stt">Mã</th>
                                        <th>Order</th>
                                        <th>Vận chuyển</th>
                                        <th>Chủ Order</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @if(count($orders) > 0)
                                        @foreach($orders as $key => $order)
                                            <tr>
                                                <td class="text-center">{{$key + 1}}</td>
                                                <td class="text-center bold">
                                                    <a href="{{URL::action('Admin\OrderController@info', $order->order_id)}}">
                                                        #{{$order->code}} <br>
                                                        <a type="button" title="Xem"
                                                           class="btn btn-xs btn-primary tooltips m-r-0"
                                                           href="{{URL::action('Admin\OrderController@info', $order->order_id)}}">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </a>
                                                </td>
                                                <td>
                                            <span class="font-green bold font-12">
                                                <a href="{{URL::action('Admin\OrderController@info', $order->order_id)}}">
                                                    {{$order->name}}
                                                </a>
                                            </span>
                                                    <br>

                                                    @if($order->link)
                                                        + Website: <a href="{{$order->link}}" target="_blank">
                                                            <?php
                                                            try {
                                                                echo parse_url($order->link)['host'];
                                                            } catch (Exception $e) {
                                                            }
                                                            ?>
                                                        </a>
                                                        <br>
                                                    @endif

                                                    + Số lượng: {{$order->quantity}} <br>
                                                    + Tổng: <span class="bold">{{$order->quantity * $order->price}}
                                                        $</span>
                                                </td>
                                                <td class="text-top">
                                                    @if($order->deliver_date)
                                                        + Ngày:
                                                        <strong>{{date('d-m-Y', strtotime($order->deliver_date))}} </strong>
                                                        <br>
                                                    @endif
                                                    @if($order->from_location != null)
                                                        + Từ: {{$order->from_location->name}} <br>
                                                    @endif
                                                    @if($order->to_location != null)
                                                        + Đến: {{$order->to_location->name}}
                                                    @endif
                                                </td>
                                                <td class="text-top">
                                                    <strong>
                                                        {{$order->account->first_name . ' ' . $order->account->last_name}}
                                                    </strong>
                                                    <br>
                                                    + Email: {{$order->account->email}}
                                                </td>
                                                <td class="{{$order_status[$order->order_status]['class']}}"
                                                    align="center">
                                                    {{$order_status[$order->order_status]['name']}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center font-grey-mint bold">Không có Order</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-center">{!!  $orders->appends(Request::except('page'))->links() !!}</div>
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
    {{Html::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}

    {{Html::script('assets/global/plugins/moment.min.js')}}
    {{Html::script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}

    <script>
        $(document).ready(function () {
            var is_advance = parseInt($("#is_advance").val());
            if (is_advance == 1) {
                show_advance();
            } else {
                hide_advance();
            }
        });

        $("#advance").click(function () {
            var is_advance = parseInt($("#is_advance").val());
            if (is_advance == 1) {
                $("#is_advance").val(0);
                hide_advance();
            } else {
                $("#is_advance").val(1);
                show_advance();
            }
        });

        function show_advance() {
            $("#advance").html("Thu gọn <i class='fa fa-caret-down'></i>");

            $(".row-advance").each(function () {
                $(this).prop('hidden', false);
                $(this).find('.form-control').prop('disabled', false);
            });
        }

        function hide_advance() {
            $("#advance").html("Tìm kiếm nâng cao <i class='fa fa-caret-right'></i>");

            $(".row-advance").each(function () {
                $(this).prop('hidden', true);
                $(this).find('.form-control').prop('disabled', true);
            });
        }

        $("#reset").click(function () {
            window.location.href = "{{URL::current()}}";
        });

        $(function () {
            jQuery().daterangepicker && ($("#dashboard-report-range").daterangepicker(
                    {
                        startDate: "<?php echo $start?>",
                        endDate: "<?php echo $end?>",
                        maxDate: "<?php echo $max?>",
                        ranges: {
                            "Tháng này": [moment().startOf("month"), moment().endOf("month")],
                            "Tháng trước": [moment().subtract("month", 1).startOf("month"), moment().subtract("month", 1).endOf("month")]
                        },
                        opens: App.isRTL() ? "right" : "left"
                    }, function (e, t, a) {
                        "0" != $("#dashboard-report-range").attr("data-display-range") && $("#dashboard-report-range span").html(e.format("YYYY-MM-DD") + " - " + t.format("YYYY-MM-DD")), load_data()
                    }), "0" != $("#dashboard-report-range").attr("data-display-range") && $("#dashboard-report-range span").html("<?php echo $start . ' - ' . $end?>"), $("#dashboard-report-range").show())
        });

        function load_data() {
            window.location.href = "{{URL::action('Admin\OrderController@index')}}" +
                    "?start=" + $("#dashboard-report-range span").html().split(" - ")[0] +
                    "&end=" + $("#dashboard-report-range span").html().split(" - ")[1];
        }
    </script>
@endsection