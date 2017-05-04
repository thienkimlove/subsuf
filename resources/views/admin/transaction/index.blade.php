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
            <span class="bold">Quản lý Giao dịch</span>
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
                                {{$statistics['number']['total']}}
                            </span>
                        </h3>
                        <small>GIAO DỊCH</small>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: 100%;"
                              class="progress-bar progress-bar-success green-sharp">
                            <span class="sr-only">76% progress</span>
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
                        <h3 class="font-purple-soft">
                            <span data-counter="counterup" data-value="1349">
                                {{$statistics['number']['new']}}
                            </span>
                        </h3>
                        <small>MỚI</small>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: {{$statistics['percent']['new']}}%;"
                              class="progress-bar progress-bar-success purple-soft">
                            <span class="sr-only">100% tổng</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"> Tổng</div>
                        <div class="status-number"> {{$statistics['percent']['new']}}%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-yellow-gold">
                            <span data-counter="counterup" data-value="567">
                                {{$statistics['number']['trading']}}
                            </span>
                        </h3>
                        <small>ĐANG GIAO DỊCH</small>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: {{$statistics['percent']['trading']}}%;"
                              class="progress-bar progress-bar-success yellow-gold">
                            <span class="sr-only">45% tăng</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"></div>
                        <div class="status-number"> {{$statistics['percent']['trading']}}%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-green-jungle">
                            <span data-counter="counterup" data-value="276">
                                {{$statistics['number']['done']}}
                            </span>
                        </h3>
                        <small>THÀNH CÔNG</small>
                    </div>
                </div>
                <div class="progress-info">
                    <div class="progress">
                        <span style="width: {{$statistics['percent']['done']}}%;"
                              class="progress-bar progress-bar-success green-jungle">
                            <span class="sr-only">56% change</span>
                        </span>
                    </div>
                    <div class="status">
                        <div class="status-title"></div>
                        <div class="status-number"> {{$statistics['percent']['done']}}%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-trademark font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Danh sách Giao dịch</span>
                    </div>
                    <div class="pull-right">
                        <a type="button" class="btn green btn-sm uppercase"
                           href="{{URL::action("Admin\TransactionController@fakeTransaction")}}">
                            <i class="fa fa-plus"></i>
                            Tạo giao dịch fake
                        </a>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\TransactionController@index', 'method' => 'GET', 'id' => 'search-transaction-form'])}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-sm" style="margin-bottom: 0">
                                <select name="transaction_status" id="transaction_status"
                                        class="form-control input-sm select2-auto">
                                    <option value="" selected>--- Trạng thái ---</option>
                                    @foreach($transaction_status as $key => $status)
                                        <option value="{{$key}}"
                                                @if(old('transaction_status') == $key) selected @endif>{{$status['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="transaction_date" id="transaction_date"
                                   placeholder="Ngày giao dịch"
                                   class="form-control input-sm date-picker clearable"
                                   value="{{old('transaction_date')}}">
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fa fa-search" style="margin-top: 8px"></i>
                                    <input class="form-control input-sm clearable" type="number" name="transaction_id"
                                           id="transaction_id" value="{{old('transaction_id')}}"
                                           placeholder="Mã giao dịch...">
                                </div>

                                <span class="input-group-btn">
                                    <a role="button" class="btn btn-sm default block-button" id="reset">
                                        <i class="fa fa-refresh"></i>
                                        Reset
                                    </a>

                                    <button id="search_transaction" class="btn btn-sm btn-success" type="submit">
                                    Tìm kiếm
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="stt">STT</th>
                                    <th class="stt">Mã</th>
                                    <th class="fit">Ngày</th>
                                    <th>Người mua</th>
                                    <th>Người mua hộ</th>
                                    <th width="100px">Tổng tiền ($)</th>
                                    <th width="150">Trạng thái</th>
                                    <th width="50"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $key => $transaction)
                                    <tr>
                                        <td class="stt">{{$key + 1}}</td>
                                        <td class="text-center">
                                            <a role="button" class="btn btn-xs bg-primary"
                                               href="{{URL::action('Admin\TransactionController@info', $transaction->transaction_id)}}">
                                                Xem <strong>#{{$transaction->transaction_id}}</strong>
                                            </a>
                                        </td>
                                        <td align="right">{{date('d-m-Y', strtotime($transaction->transaction_date))}}</td>
                                        <td class="text-top">
                                            @if(isset($transaction->offer->order))
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
                                            ${{number_format(($transaction->total), 2, '.', ',')}}
                                        </td>
                                        <td align="center"
                                            class="{{$transaction_status[$transaction->transaction_status]['class']}}">
                                            {{$transaction_status[$transaction->transaction_status]['name']}}
                                            @if($transaction->is_fake)
                                                (FAKE)
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaction->is_fake)
                                                <a href="{{URL::action( 'Admin\TransactionController@removeTransaction',$transaction->transaction_id)}}"
                                                   class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="text-center">{!!  $transactions->appends(Request::except('page'))->links() !!}</div>
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
            window.location.href = "{{URL::action('Admin\TransactionController@index')}}" +
                    "?start=" + $("#dashboard-report-range span").html().split(" - ")[0] +
                    "&end=" + $("#dashboard-report-range span").html().split(" - ")[1];
        }
    </script>
@endsection