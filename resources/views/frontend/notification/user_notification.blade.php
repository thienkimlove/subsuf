@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
@endsection
@section('breadcrumb')

@endsection
@section('content')
    <div class="container">
        <div class="row margin-top-40 stories-header" data-auto-height="true">
            <div class="col-md-12 text-center">
                <h1 style="font-weight: 400 !important;">{{$title}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-xs-offset-0">
                <div class="portlet light bordered" style="padding: 5px; !important;">
                    @if(count($notifications) > 0)
                        @foreach($notifications as $notification)
                            <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification->order_id)
                        ."?notification=" . $notification->notification_id}}" style="text-decoration: none !important;">
                                <div class="mt-actions"
                                     style="@if($notification->is_read == 0) background-color: #e7ecf1 !important; @endif">
                                    @if(strpos($notification->content_en, 'payment_success' ) !== false)
                                        <div class="mt-action">
                                            <div class="mt-action-img" style="margin-left: 10px;">
                                                <img src="{{'/assets/subsuf_img/logo.png'}}" alt=""
                                                     style="max-width: 30px">
                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details ">
                                                <span class="mt-action-author">
                                                    {!! get_payment_success_message($notification, App::getLocale()) !!}
                                                </span>
                                                            <div style="margin-top: 5px" class="mt-action-desc">
                                                                {{reltativeDate(date("H:i d-m-Y", strtotime($notification->sent_at)))}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-action">
                                            <div class="mt-action-img" style="margin-left: 10px;">
                                                <img @if($notification->from_user->avatar == '') src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                                     @else src="{{URL::to($notification->from_user->avatar)}}" @endif alt=""
                                                     style="max-width: 30px">
                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details ">
                                                <span class="mt-action-author">
                                                    {{trim($notification->from_user->first_name . " " . $notification->from_user->last_name)}}
                                                    <span style="font-weight: normal !important;">
                                                        {{$notification["content_" . App::getLocale()]}}
                                                    </span>
                                                    {{$notification->order->name}}
                                                </span>
                                                            <div style="margin-top: 5px" class="mt-action-desc">
                                                                {{reltativeDate(date("H:i d-m-Y", strtotime($notification->sent_at)))}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach

                        <div class="text-center">{!!  $notifications->appends(Request::except('page'))->links() !!}</div>
                    @else
                        <h3 class="text-center">{{trans("index.banchuacothongbao")}}</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>

    </script>
@endsection