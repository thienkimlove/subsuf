<header class="header">
    <div class="container">
        <div class="Dwrap_Unavbar_C">
            <div class="Dnavbar_Uwrap_C">

                <div class="logo_btn_nhanmuaho">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <img src="{{url('v2/images/icon-menu-mobile.png')}}" alt="icon-menu">
                    </button>
                    <a class="logo" href="{{url('/')}}"><img src="{{url('v2/images/logo.png')}}" alt="logo Biz plus"></a>
                    <a class="btn_link active" href="{{url('traveler')}}">
                        <i class="fa fa-plane" aria-hidden="true"></i>
                        <span>{{trans('index.v2_nhanmuaho')}}</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse Dnavbar_Ucollapse_C" id="bs-example-navbar-collapse-1">
                    <nav class="wrap-nav">
                        <ul id="nav" class="nav navbar-nav navigation">
                            @if (session()->has('userFrontend'))

                                @if(count(session()->get("userFrontend")->payment_cards) > 0 || count(session()->get("userFrontend")->paypals) > 0)
                                    <li class="active">
                                        <a href="{{url('traveler')}}" class="btn-muaho">{{trans('index.v2_trothanhnguoimuaho')}}</a>
                                    </li>
                                @else
                                    <li class="active">
                                        <a href="{{url('user/payment-info')}}" class="btn-muaho">{{trans('index.v2_trothanhnguoimuaho')}}</a>
                                    </li>
                                @endif
                                    <?php
                                    $notifications = session()->get("userFrontend")->notifications()->unread()->get();
                                    $unread = count($notifications);
                                    ?>
                                    <li class="dropdown dropdown-extended dropdown-notification " id="header_notification_bar">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                            <i class="ti-bell"></i>
                                            @if($unread > 0)
                                                <span class="badge badge-default">
                                                    {{$unread}}
                                                </span>
                                            @endif

                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="external">
                                                @if((int)$unread>1)
                                                    <p><a href="{{url('notifications', session()->get('userFrontend')->account_id)}}">{!! trans('index.bancotinnhan_n', ['number' => $unread]) !!}</a></p>
                                                @else
                                                    <p><a href="{{url('notifications', session()->get('userFrontend')->account_id)}}">{!! trans('index.bancotinnhan', ['number' => $unread]) !!}</a></p>
                                                @endif
                                                &nbsp;&nbsp;
                                                <p> <a href="{{url('notifications', session()->get('userFrontend')->account_id)}}">
                                                        {{trans("index.xemtatca")}}
                                                    </a>
                                                </p>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="dropdown dropdown-user">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
                                           data-hover="dropdown" data-close-others="true">

                                            <img style="max-height: 40px" alt="" class="img-circle"
                                                 src="{{url(session()->get('userFrontend')->avatar)}}">
                                            <span class="username font-dark username-hide-mobile">
                                                <b>{{session()->get("userFrontend")->first_name." ".session()->get("userFrontend")->last_name}}</b>
                                            </span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-default">
                                            <li>
                                                <a href="{{url('user/profile')}}">
                                                    <i class="icon-user"></i> {{trans("index.thongtintaikhoan")}}</a>
                                            </li>

                                            <li>
                                                <a href="{{url('logout')}}">
                                                    <i class="icon-key"></i> {{trans("index.dangxuat")}} </a>
                                            </li>
                                        </ul>
                                    </li>
                                    @foreach (\App\Category::orderBy("category_id", "ASC")->get() as $category)
                                        @if($category->category_id == 7)
                                            @continue
                                        @endif
                                        <li class="hidden-lg">
                                            <a href="{{url('collections/featured-items?category='. $category->category_id)}}">
                                                <img class="icon" src="{{url($category->image)}}" height="41" width="33"
                                                     alt="">
                                                <span>{{$category->name}}</span>
                                            </a>
                                        </li>
                                    @endforeach


                            @else

                                <li class="active">
                                    <a href="{{url('register')}}" class="btn-muaho">{{trans('index.v2_trothanhnguoimuaho')}}</a>
                                </li>

                                <li>
                                    <a href="{{url('register')}}">{{trans('index.v2_dangky')}}</a>
                                </li>
                                <li>
                                    <a href="{{url('login')}}">{{trans('index.v2_dangnhap')}}</a>
                                </li>


                                @foreach (\App\Category::orderBy("category_id", "ASC")->get() as $category)
                                    @if($category->category_id == 7)
                                        @continue
                                    @endif
                                    <li class="hidden-lg">
                                        <a href="{{url('collections/featured-items?category='. $category->category_id)}}">
                                            <img class="icon" src="{{url($category->image)}}" height="41" width="33"
                                                 alt="">
                                            <span>{{$category->name}}</span>
                                        </a>
                                    </li>
                                @endforeach


                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>