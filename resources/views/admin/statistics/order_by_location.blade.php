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
        .table.order-detail td {
            font-size: 13px !important;
            color: #000000 !important;
        }

        .table.order-detail th {
            color: #000000 !important;
        }

        .number-stats .stat-number .number {
            color: #000000 !important;
        }

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
            <span class="bold">Thống kê Order của User</span>
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
                        <i class="fa fa-map-marker font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Order theo Địa điểm</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-icon form-group form-group-sm">
                                    <select name="location_id" id="location_id"
                                            class="form-control input-sm select2-multiple-auto" multiple>
                                        @foreach($locations as $location)
                                            <option value="{{$location->location_id}}"
                                                    @if(in_array($location->location_id, $location_ids)) selected @endif>{{$location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <span class="input-group-btn">
                                    <button id="get_data" class="btn btn-sm btn-success">
                                    Lấy dữ liệu
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row number-stats margin-bottom-30">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="stat-number" style="float: right!important; text-align: right">
                                <div class="title"> Tổng Order</div>
                                <div class="number"> {{number_format($statistics['total']['orders'])}}</div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="stat-number">
                                <div class="title"> Tổng Offer</div>
                                <div class="number"
                                     style="float: left!important; text-align: left!important;">
                                    {{number_format($statistics['total']['offers'])}}</div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-hover table-light order-detail sorted-table">
                        <thead>
                        <tr class="uppercase">
                            <th> Thành phố</th>
                            <th> Orders</th>
                            <th> Offers</th>
                            <th> Tiền thưởng</th>
                            <th> Tỷ lệ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($location_ids as $id)
                            <tr>
                                <td class="primary-link">
                                    {{isset($locations[$id]) ?$locations[$id]['name']:""}}
                                </td>
                                <td class="theme-font text-right">
                                    {{isset($statistics[$id]) ? number_format($statistics[$id]['orders']) : 0}}
                                </td>
                                <td class="theme-font text-right">
                                    {{isset($statistics[$id]) ? number_format($statistics[$id]['offers']) : 0}}
                                </td>
                                <td class="theme-font text-right">
                                    {{isset($statistics[$id]) ? number_format($statistics[$id]['rewards']) : 0}}
                                </td>
                                <td class="theme-font text-right">
                                    {{isset($statistics['percent'][$id]) ? $statistics['percent'][$id] : 0}}%
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/select2/js/select2.full.min.js')}}

    {{Html::script('assets/global/plugins/moment.min.js')}}
    {{Html::script('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js')}}

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
            window.location.href = "{{URL::action('Admin\StatisticsController@order_by_location')}}" +
                    "?start=" + $("#dashboard-report-range span").html().split(" - ")[0] +
                    "&end=" + $("#dashboard-report-range span").html().split(" - ")[1] +
                    "&location_id=" + $('#location_id').val();
        }

        $('#get_data').click(function () {
            load_data();
        });
    </script>
@endsection