@extends('frontend.layout.template')
@section('style')
    {{Html::style("assets/pages/css/profile.min.css")}}
@endsection
@section('breadcrumb')

@endsection

@section('content')
    @include("frontend.message")
    <div class="container margin-top-40">
        <div class="col-md-12">
            <div class="profile-sidebar">
                @include("frontend.user.profile_menu")
            </div>

            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption caption-md">
                                    <i class="fa fa-credit-card font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">
                                        {{trans("index.taikhoannganhang")}}
                                    </span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach($user->payment_cards as $card)
                                            <div class="well" style="font-size: 12px">
                                                {{--<div class="row">--}}
                                                {{--<div class="col-xs-4">{{trans("index.quocgia")}}</div>--}}
                                                {{--<div class="col-xs-6">{{$card->country_of_bank}}</div>--}}
                                                {{--</div>--}}
                                                <div class="row">
                                                    <div class="col-xs-4">{{trans("index.sotaikhoan")}}</div>
                                                    <div class="col-xs-6 bold">{{$card->account_number}}</div>
                                                    <div class="col-xs-2">
                                                        <a role="button" class="btn btn-xs yellow-gold"
                                                           data-target="#payment_card_info" data-toggle="modal"
                                                           href="{{URL::action('Frontend\UserController@edit_card', $card->payment_info_id)}}">
                                                            {{trans("index.edit")}}
                                                        </a>
                                                        <a role="button" class="btn btn-xs red"
                                                           onclick="return confirm('{{trans('index.confirm_delete')}}')"
                                                           href="{{URL::action('Frontend\UserController@delete_card', $card->payment_info_id)}}">
                                                            {{trans("index.delete")}}
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-4">{{trans("index.tenchutaikhoan")}}</div>
                                                    <div class="col-xs-6 bold">{{$card->name}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-4">{{trans("index.tennganhangqt")}}</div>
                                                    <div class="col-xs-6 bold">{{$card->bank_name}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-4">{{trans("index.chinhanh")}}</div>
                                                    <div class="col-xs-6">{{$card->bank_department}}</div>
                                                </div>
                                                {{--<div class="row">--}}
                                                {{--<div class="col-xs-4">Swift Code</div>--}}
                                                {{--<div class="col-xs-6">{{$card->swift_code}}</div>--}}
                                                {{--</div>--}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <a role="button" class="btn green"
                                           data-target="#payment_card_info" data-toggle="modal"
                                           href="{{URL::action('Frontend\UserController@add_card')}}">
                                            <i class="fa fa-plus"></i> {{trans("index.add_account")}}
                                        </a>
                                    </div>
                                </div>

                                <div id="payment_card_info" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true"></button>
                                                <h4 class="modal-title text-uppercase">
                                                    <i class="fa fa-circle-o-notch fa-spin"></i>
                                                    {{trans("index.loading")}}
                                                </h4>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption caption-md">
                                            <i class="fa fa-paypal font-green"></i>
                                            <span class="caption-subject font-green bold uppercase">{{trans('index.tkpaypal')}}</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        @foreach($user->paypals as $paypal)
                                            <div class="well" style="font-size: 12px">
                                                <div class="row">
                                                    <div class="col-xs-4">PayPal Email:</div>
                                                    <div class="col-xs-6 bold">{{$paypal->paypal_email}}</div>
                                                    <div class="col-xs-2">
                                                        <a role="button" class="btn btn-xs yellow-gold"
                                                           data-target="#paypal_info" data-toggle="modal"
                                                           href="{{URL::action('Frontend\UserController@edit_paypal', $paypal->payment_info_id)}}">
                                                            {{trans("index.edit")}}
                                                        </a>
                                                        <a role="button" class="btn btn-xs red"
                                                           onclick="return confirm('{{trans('index.confirm_delete')}}')"
                                                           href="{{URL::action('Frontend\UserController@delete_paypal', $paypal->payment_info_id)}}">
                                                            {{trans("index.delete")}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <a role="button" class="btn green"
                                                   data-target="#paypal_info" data-toggle="modal"
                                                   href="{{URL::action('Frontend\UserController@add_paypal')}}">
                                                    <i class="fa fa-plus"></i> {{trans("index.add_account")}}
                                                </a>
                                            </div>
                                        </div>

                                        <div id="paypal_info" class="modal fade" tabindex="-1">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        <h4 class="modal-title text-uppercase">
                                                            <i class="fa fa-circle-o-notch fa-spin"></i>
                                                            {{trans("index.loading")}}
                                                        </h4>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection