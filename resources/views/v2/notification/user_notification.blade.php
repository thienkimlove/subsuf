
@extends('v2.template')

@section('content')
<div class="wrap_container">

    <div class="wrap_ThongBao">
        <div class="container">
            <h1 class="title_block">Thông báo</h1>
            <div class="list_thongbao">
                @if(count($notifications) > 0)
                    @foreach($notifications as $notification)

                        @if(strpos($notification->content_en, 'payment_success' ) !== false)

                <div class="media">
                    <div class="media-left">
                        <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification->order_id)
                        ."?notification=" . $notification->notification_id}}">

                                <img class="media-object" src="{{'/assets/subsuf_img/logo.png'}}" alt="...">


                        </a>
                    </div>
                    <div class="media-body">
                        <p class="media-heading">

                            <b> {!! get_payment_success_message($notification, App::getLocale()) !!}</b>

                        </p>
                        <p class="datetime">{{reltativeDate(date("H:i d-m-Y", strtotime($notification->sent_at)))}}</p>
                    </div>
                </div>

                        @else

                            <div class="media">
                                <div class="media-left">
                                    <a href="{{URL::action('Frontend\ShopperController@orderDetail', $notification->order_id)
                        ."?notification=" . $notification->notification_id}}">

                                        <img class="media-object" @if($notification->from_user->avatar == '') src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                                             @else src="{{URL::to($notification->from_user->avatar)}}" @endif alt=""
                                             >


                                    </a>
                                </div>
                                <div class="media-body">
                                    <p class="media-heading">

                                        <b> {{trim($notification->from_user->first_name . " " . $notification->from_user->last_name)}}</b>
                                        {{$notification["content_" . App::getLocale()]}}
                                        <b> {{$notification->order->name}}</b>
                                    </p>
                                    <p class="datetime">{{reltativeDate(date("H:i d-m-Y", strtotime($notification->sent_at)))}}</p>
                                </div>
                            </div>

                            @endif

                    @endforeach
                    @else
                    <h2 class="title_block">{{trans("index.banchuacothongbao")}}</h2>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection