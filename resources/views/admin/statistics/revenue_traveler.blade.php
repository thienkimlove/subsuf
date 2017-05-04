@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}

    {{Html::style('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}
    {{Html::style('assets/global/plugins/morris/morris.css')}}

    {{Html::style('assets/pages/css/profile.min.css')}}

    {{Html::style('assets/global/plugins/datatables/datatables.min.css')}}
    {{Html::style('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}

    <style>
        .number-stats .stat-number .title {
            color: #000000 !important;
        }
    </style>
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thống kê Doanh thu Traveler</span>
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
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-dollar font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Doanh thu Traveler</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\StatisticsController@revenue_of_traveler', 'method' => 'GET', 'id' => 'search-transaction-form'])}}
                    <div class="row">
                        <div class="col-sm-offset-3 col-sm-6">
                            <div class="input-group">
                                <div class="input-icon form-group form-group-sm">
                                    <select name="account_id" id="account_id"
                                            class="form-control input-sm select2-auto">
                                        <option value="" selected>--- Chọn người dùng ---</option>
                                        @foreach($accounts as $account)
                                            <option value="{{$account->account_id}}"
                                                    @if(old('account_id') == $account->account_id) selected @endif>{{$account['email']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <span class="input-group-btn">
                                    <button id="search_transaction" class="btn btn-sm btn-success" type="submit">
                                    Lấy dữ liệu
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

    @if(isset($selected_account))
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green bold uppercase">CHI TIẾT</span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="profile-userpic">
                            <img @if($selected_account->avatar == '') src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                 @else src="{{$selected_account->avatar}}" @endif class="img-responsive" alt=""
                                 style="max-width: 85px;">
                        </div>

                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name">
                            <span class="full-name" style="font-size: 14px">
                                {{$selected_account->first_name . ' ' . $selected_account->last_name}}
                            </span>
                            </div>
                            <div class="">{{$selected_account->email}}</div>
                        </div>

                        <hr>

                        <div class="row number-stats margin-bottom-30">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="stat-number" style="float: right!important; text-align: right">
                                    <div class="title"> Doanh thu tạm tính</div>
                                    <div class="number font-yellow-gold">
                                        ${{number_format($statistics['total_temp'], 2, '.', ',')}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="stat-number">
                                    <div class="title"> Doanh thu thực tế</div>
                                    <div class="number font-green-jungle"
                                         style="float: left!important; text-align: left!important;">
                                        ${{number_format($statistics['total_reality'], 2, '.', ',')}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover sorted-table-paginate">
                                    <thead>
                                    <tr>
                                        <th class="fit">STT</th>
                                        <th class="stt">Mã</th>
                                        <th>Ngày</th>
                                        <th>Người mua</th>
                                        <th>Người mua hộ</th>
                                        <th width="100px">Doanh thu ($)</th>
                                        <th width="100px">Trạng thái</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $key => $transaction)
                                        <tr>
                                            <td class="stt">{{$key + 1}}</td>
                                            <td class="text-center">
                                                <a role="button" class="btn btn-xs bg-primary" target="_blank"
                                                   href="{{URL::action('Admin\TransactionController@info', $transaction->transaction_id)}}">
                                                    Xem <strong>#{{$transaction->transaction_id}}</strong>
                                                </a>
                                            </td>
                                            <td align="right">{{date('d-m-Y', strtotime($transaction->transaction_date))}}</td>
                                            <td class="text-top">
                                                @if($transaction->offer->order != null)
                                                    <strong>
                                                        {{$transaction->offer->order->account->first_name . ' ' . $transaction->offer->order->account->last_name}}
                                                    </strong>
                                                    <br>
                                                    + Email: {{$transaction->offer->order->account->email}}
                                                @endif
                                            </td>
                                            <td class="text-top">
                                                @if($transaction->offer != null)
                                                    <strong>
                                                        {{$transaction->offer->account->first_name . ' ' . $transaction->offer->account->last_name}}
                                                    </strong>
                                                    <br>
                                                    + Email: {{$transaction->offer->account->email}}
                                                @endif
                                            </td>
                                            <td class="text-right bold">
                                                <?php
                                                $offer = $transaction->offer;
                                                $order = $offer->order;

                                                $money = $offer->shipping_fee + $offer->tax + $offer->others_fee + $order->price * $order->quantity;
                                                ?>
                                                ${{number_format(($money), 2, '.', ',')}}
                                            </td>
                                            <td align="center"
                                                class="{{$transaction_status[$transaction->transaction_status]['class']}}">
                                                {{$transaction_status[$transaction->transaction_status]['name']}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}

    {{Html::script('assets/global/plugins/moment.min.js')}}
    {{Html::script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}

    {{Html::script('assets/global/plugins/highcharts/js/highcharts.js')}}

    {{Html::script('assets/global/scripts/datatable.js')}}
    {{Html::script('assets/global/plugins/datatables/datatables.min.js')}}
    {{Html::script('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}
    <script>
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
            window.location.href = "{{URL::action('Admin\StatisticsController@revenue_of_traveler')}}" +
                    "?start=" + $("#dashboard-report-range span").html().split(" - ")[0] +
                    "&end=" + $("#dashboard-report-range span").html().split(" - ")[1] +
                    "&account_id=" + "{{$account_id}}";
        }

        @if(isset($statistics))
        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    text: "Doanh thu từ {{date('d-m-Y', strtotime($start))}} đến {{date('d-m-Y', strtotime($end))}}"
                },
                subtitle: {
                    text: 'Đơn vị: USD($)'
                },
                xAxis: {
                    categories: [
                        <?php
                        foreach ($statistics['days'] as $item_x) {
                            if ($item_x != 0 && $item_x != '0') {
                                echo '"' . date('d-m-y', strtotime($item_x)) . '",';
                            }
                        }
                        ?>
                    ]
                },
                yAxis: {
                    title: {
                        text: 'USD ($)'
                    }
                },
                tooltip: {crosshairs: true, shared: true},
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    name: 'Doanh thu tạm tính',
                    data: [<?php foreach ($statistics['data_temp'] as $item) {
                        echo $item . ',';
                    } ?>],
                    color: "#E87E04"
                }, {
                    name: 'Doanh thu thực tế',
                    data: [<?php foreach ($statistics['data_reality'] as $item) {
                        echo $item . ',';
                    } ?>],
                    color: "#26C281"
                }]
            });
        });
        @endif
    </script>
@endsection