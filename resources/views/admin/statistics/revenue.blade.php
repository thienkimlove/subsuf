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
            <span class="bold">Thống kê Doanh thu</span>
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
            window.location.href = "{{URL::action('Admin\StatisticsController@revenue')}}" +
                    "?start=" + $("#dashboard-report-range span").html().split(" - ")[0] +
                    "&end=" + $("#dashboard-report-range span").html().split(" - ")[1];
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