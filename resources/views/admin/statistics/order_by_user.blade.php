@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}

    {{Html::style('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}
    {{Html::style('assets/global/plugins/morris/morris.css')}}

    {{Html::style('assets/pages/css/profile.min.css')}}

    <style>
        .mt-element-list .list-todo.mt-list-container ul > .mt-list-item > .list-todo-item {
            width: 95% !important;
        }

        .mt-element-list .list-todo.mt-list-container ul > .mt-list-item > .list-todo-item .task-list .task-list-item {
            border-bottom: 1px solid !important;
            border-color: #e7ecf1 !important;
        }

        .order-name {
            margin-bottom: 10px;
        }

        .order-deliver {
            margin-bottom: 5px;
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
                        <i class="fa fa-shopping-cart font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Order của User</span>
                    </div>
                </div>

                <div class="portlet-body">
                    {{Form::open(['action' => 'Admin\StatisticsController@order_by_user', 'method' => 'GET', 'id' => 'search-transaction-form'])}}
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

                        <br>

                        <div class="mt-element-list">
                            <div class="mt-list-container list-todo">
                                <ul>
                                    <!-- PENDING -->
                                    <li class="mt-list-item" style="border-top: 1px solid; border-color: #e7ecf1">
                                        <div class="list-todo-icon bg-white">
                                            <i class="fa fa-hourglass-2 font-yellow-gold"></i>
                                        </div>
                                        <div class="list-todo-item yellow-gold">
                                            <a class="list-toggle-container" data-toggle="collapse"
                                               data-parent="#accordion1" onclick=" " href="#pending"
                                               aria-expanded="true">
                                                <div class="list-toggle done uppercase">
                                                    <div class="list-toggle-title bold">Đang giao dịch</div>
                                                    <div class="badge badge-default pull-right bold">{{count($statistics[2])}}</div>
                                                </div>
                                            </a>
                                            <div class="task-list panel-collapse collapse in" id="pending"
                                                 aria-expanded="true">
                                                <ul>
                                                    @if(isset($statistics[2]) && count($statistics[2]) > 0)
                                                        @foreach($statistics[2] as $item)
                                                            <li class="task-list-item">
                                                                <div class="row">
                                                                    <div class="col-sm-2 text-center">
                                                                        <img @if(!isset($item->order_images)) src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                                                             @else src="{{$item->order_images[0]['image']}}"
                                                                             @endif class="" alt=""
                                                                             style="max-width: 60px;">
                                                                    </div>
                                                                    <div class="col-sm-10">
                                                                        <div class="order-name">
                                                                            <a href="{{URL::action('Admin\OrderController@info', $item->order_id)}}"
                                                                               target="_blank">
                                                                                <strong class="font-16  ">{{$item->name}}</strong>
                                                                            </a>
                                                                        </div>
                                                                        <div class="order-deliver">
                                                                            Vận chuyển đến: {{$item->to_location->name}}
                                                                        </div>
                                                                        <div class="order-deliver">
                                                                            Giá trị:
                                                                            ${{number_format(($item->price * $item->quantity), 2, '.', ',')}}
                                                                        </div>
                                                                        <div>
                                                                            Yêu cầu
                                                                            lúc: {{date('H:i d-m-Y', strtotime($item->request_time))}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li class="task-list-item">
                                                            <div class="row">
                                                                <div class="col-sm-12 text-center">Chưa có Order nào
                                                                    Đang
                                                                    giao dịch
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- ACTIVE -->
                                    <li class="mt-list-item">
                                        <div class="list-todo-icon bg-white">
                                            <i class="fa fa-shopping-cart font-green"></i>
                                        </div>
                                        <div class="list-todo-item green">
                                            <a class="list-toggle-container font-white" data-toggle="collapse"
                                               href="#active" aria-expanded="false">
                                                <div class="list-toggle done uppercase">
                                                    <div class="list-toggle-title bold">ĐANG KÍCH HOẠT</div>
                                                    <div class="badge badge-default pull-right bold">{{count($statistics[1])}}</div>
                                                </div>
                                            </a>
                                            <div class="task-list panel-collapse collapse" id="active">
                                                <ul>
                                                    @if(isset($statistics[1]) && count($statistics[1]) > 0)
                                                        @foreach($statistics[1] as $item)
                                                            <li class="task-list-item">
                                                                <div class="row">
                                                                    <div class="col-sm-2 text-center">
                                                                        <img @if(!isset($item->order_images)) src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                                                             @else src="{{$item->order_images[0]['image']}}"
                                                                             @endif class="" alt=""
                                                                             style="max-width: 60px;">
                                                                    </div>
                                                                    <div class="col-sm-10">
                                                                        <a href="{{URL::action('Admin\OrderController@info', $item->order_id)}}"
                                                                           target="_blank">
                                                                            <strong class="font-16  ">{{$item->name}}</strong>
                                                                        </a>
                                                                        <div class="order-deliver">
                                                                            Vận chuyển đến: {{$item->to_location->name}}
                                                                        </div>
                                                                        <div class="order-deliver">
                                                                            Giá trị:
                                                                            ${{number_format(($item->price * $item->quantity), 2, '.', ',')}}
                                                                        </div>
                                                                        <div>
                                                                            Yêu cầu
                                                                            lúc: {{date('H:i d-m-Y', strtotime($item->request_time))}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li class="task-list-item">
                                                            <div class="row">
                                                                <div class="col-sm-12 text-center">Chưa có Order nào
                                                                    Đang
                                                                    kích hoạt
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- INACTIVE -->
                                    <li class="mt-list-item">
                                        <div class="list-todo-icon bg-white">
                                            <i class="fa fa-ban font-red"></i>
                                        </div>
                                        <div class="list-todo-item red">
                                            <a class="list-toggle-container font-white" data-toggle="collapse"
                                               href="#inactive" aria-expanded="false">
                                                <div class="list-toggle done uppercase">
                                                    <div class="list-toggle-title bold">Đã hủy</div>
                                                    <div class="badge badge-default pull-right bold">{{count($statistics[-1])}}</div>
                                                </div>
                                            </a>
                                            <div class="task-list panel-collapse collapse" id="inactive">
                                                <ul>
                                                    @if(isset($statistics[-1]) && count($statistics[-1]) > 0)
                                                        @foreach($statistics[-1] as $item)
                                                            <li class="task-list-item">
                                                                <div class="row">
                                                                    <div class="col-sm-2 text-center">
                                                                        <img @if(!isset($item->order_images)) src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                                                             @else src="{{$item->order_images[0]['image']}}"
                                                                             @endif class="" alt=""
                                                                             style="max-width: 60px;">
                                                                    </div>
                                                                    <div class="col-sm-10">
                                                                        <a href="{{URL::action('Admin\OrderController@info', $item->order_id)}}"
                                                                           target="_blank">
                                                                            <strong class="font-16  ">{{$item->name}}</strong>
                                                                        </a>
                                                                        <div class="order-deliver">
                                                                            Vận chuyển đến: {{$item->to_location->name}}
                                                                        </div>
                                                                        <div class="order-deliver">
                                                                            Giá trị:
                                                                            ${{number_format(($item->price * $item->quantity), 2, '.', ',')}}
                                                                        </div>
                                                                        <div>
                                                                            Yêu cầu
                                                                            lúc: {{date('H:i d-m-Y', strtotime($item->request_time))}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li class="task-list-item">
                                                            <div class="row">
                                                                <div class="col-sm-12 text-center">Chưa có Order nào bị
                                                                    hủy
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- COMPLETED -->
                                    <li class="mt-list-item">
                                        <div class="list-todo-icon bg-white">
                                            <i class="fa fa-check font-green-jungle"></i>
                                        </div>
                                        <div class="list-todo-item green-jungle">
                                            <a class="list-toggle-container font-white" data-toggle="collapse"
                                               href="#completed" aria-expanded="false">
                                                <div class="list-toggle done uppercase">
                                                    <div class="list-toggle-title bold">Đã hoàn thành</div>
                                                    <div class="badge badge-default pull-right bold">{{count($statistics[3])}}</div>
                                                </div>
                                            </a>
                                            <div class="task-list panel-collapse collapse" id="completed">
                                                <ul>
                                                    @if(isset($statistics[3]) && count($statistics[3]) > 0)
                                                        @foreach($statistics[3] as $item)
                                                            <li class="task-list-item">
                                                                <div class="row">
                                                                    <div class="col-sm-2 text-center">
                                                                        <img @if(!isset($item->order_images)) src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                                                             @else src="{{$item->order_images[0]['image']}}"
                                                                             @endif class="" alt=""
                                                                             style="max-width: 60px;">
                                                                    </div>
                                                                    <div class="col-sm-10">
                                                                        <a href="{{URL::action('Admin\OrderController@info', $item->order_id)}}"
                                                                           target="_blank">
                                                                            <strong class="font-16  ">{{$item->name}}</strong>
                                                                        </a>
                                                                        <div class="order-deliver">
                                                                            Vận chuyển đến: {{$item->to_location->name}}
                                                                        </div>
                                                                        <div class="order-deliver">
                                                                            Giá trị:
                                                                            ${{number_format(($item->price * $item->quantity), 2, '.', ',')}}
                                                                        </div>
                                                                        <div>
                                                                            Yêu cầu
                                                                            lúc: {{date('H:i d-m-Y', strtotime($item->request_time))}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li class="task-list-item">
                                                            <div class="row">
                                                                <div class="col-sm-12 text-center">Chưa có Order nào
                                                                    được hoành thành
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
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
            window.location.href = "{{URL::action('Admin\StatisticsController@order_by_user')}}" +
                    "?start=" + $("#dashboard-report-range span").html().split(" - ")[0] +
                    "&end=" + $("#dashboard-report-range span").html().split(" - ")[1] +
                    "&account_id=" + "{{$account_id}}";
        }
    </script>
@endsection