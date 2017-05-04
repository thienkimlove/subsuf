@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/pages/css/profile.min.css')}}

    <style>
        .table.transaction-detail td {
            font-size: 13px !important;
            color: #000000 !important;
        }

        .table.contact-detail td {
            font-size: 12px !important;
            color: #000000 !important;
        }

        .table.transaction-detail td.highlight {
            color: #32C5D2 !important;
        }

        .additional {
            color: #6b6b6b !important;
            font-size: 12px !important;
        }

        .table.transaction-detail td.money {
            font-size: 15px !important;
            text-align: right;
            font-weight: bold
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
            <a href="{{URL::action('Admin\TransactionController@index')}}">Quản lý Giao dịch</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Thông tin: Mã #{{$transaction->transaction_id}}</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">

        </div>
    </div>
@endsection

@section('pagetitle')

@endsection

@section('content')
    <h1 class="page-title">
    </h1>

    <div class="row">
        <div class="col-md-7">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-trademark font-green"></i>
                        <span class="caption-subject font-green bold uppercase">
                            Thông tin chung
                        </span>
                    </div>

                    <div class="actions">
                        <a type="button" class="btn btn-xs default tooltips m-r-0" title="Về trang Giao dịch"
                           href="{{URL::action('Admin\TransactionController@index')}}">
                            <i class="fa fa-undo"></i>
                        </a>
                    </div>
                </div>

                <div class="body">
                    <div class="table-scrollable table-scrollable-borderless">
                        <table class="table table-light transaction-detail"
                               style="max-width: 500px; margin:auto !important;">
                            <tbody>
                            <tr>
                                <td align="center" width="35%">
                                    <div class="profile-userpic">
                                        <img @if($offer->account->avatar == '') src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                             @else src="{{$offer->account->avatar}}"
                                             @endif class="img-responsive" alt=""
                                             style="max-width: 85px;">
                                    </div>
                                    <h4 class="bold">{{$offer->account->first_name . ' ' . $offer->account->last_name}}</h4>
                                    <div class="additional">{{$offer->from_location->name}}</div>
                                </td>

                                <td align="center" width="30%">
                                    <img src="{{'/assets/pages/img/plane.PNG'}}" class="img-responsive" alt=""
                                         style="max-width: 35px;">
                                    <div>{{date('d-m-Y', strtotime($offer['deliver_date']))}}</div>
                                    <div class="{{$transaction_status[$transaction->transaction_status]['class']}}">
                                        {{$transaction_status[$transaction->transaction_status]['name']}}
                                    </div>
                                </td>

                                <td align="center" width="35%">
                                    <div class="profile-userpic">
                                        <img @if($order->account->avatar == '') src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                             @else src="{{$order->account->avatar}}"
                                             @endif class="img-responsive" alt=""
                                             style="max-width: 85px;">
                                    </div>
                                    <h4 class="bold">{{$order->account->first_name . ' ' . $order->account->last_name}}</h4>
                                    <div class="additional">{{$order->to_location->name}}</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <table class="table table-light contact-detail">
                        <tr>
                            <td colspan="2" class="bg-default text-uppercase">Liên hệ</td>
                        </tr>
                        <tr>
                            <td width="30%">
                                <i class="fa fa-envelope-o"></i> Email
                            </td>
                            <td align="right">
                                {{$order->account->email}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa fa-phone"></i> Điện thoại
                            </td>
                            <td align="right">
                                {{phone_format($order->account->phone_number)}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-green bold uppercase">
                            Thông tin Hóa đơn
                        </span>
                    </div>
                </div>

                <div class="body">
                    <table class="table table-light transaction-detail">
                        <tbody>
                        <tr>
                            <td>Giao dịch lúc</td>
                            <td class="money">
                                {{date('H:i d-m-Y', strtotime($transaction->transaction_time))}}
                            </td>
                        </tr>
                        <tr>
                            <td class="highlight">
                                <a href="{{URL::action('Admin\OrderController@info', $order->order_id)}}"
                                   target="_blank">
                                    {{$order->name}}
                                </a>
                            </td>
                            <td class="money">
                                ${{number_format(($order->price * $order->quantity), 2, '.', ',')}}
                            </td>
                        </tr>

                        <tr>
                            <td>Phí mua hộ</td>
                            <td class="money">
                                ${{number_format(($offer->shipping_fee + $offer->tax + $offer->others_fee), 2, '.', ',')}}
                            </td>
                        </tr>

                        <tr>
                            <td>Phí dịch vụ</td>
                            <td class="money">
                                ${{number_format(($transaction->service_fee), 2, '.', ',')}}
                            </td>
                        </tr>

                        @if($transaction->coupon_id != 0)
                            <td>Giảm giá</td>
                            <td class="money">
                                @if($transaction->coupon)
                                    ${{number_format(($transaction->coupon->money), 2, '.', ',')}} @else 0 @endif
                            </td>
                        @endif

                        <tr>
                            <td>Tổng</td>
                            <td class="money">
                                ${{number_format(($transaction->total), 2, '.', ',')}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection