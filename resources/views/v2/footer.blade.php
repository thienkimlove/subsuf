{{--<footer class="footer">--}}
{{--<div class="main_footer">--}}
{{--<div class="container">--}}
{{--<div class="row">--}}
{{--<div class="col-xs-12 col-md-3">--}}
{{--<a href="{{url('/')}}" class="logo_text">Subsuf</a>--}}
{{--<p>{{trans('index.v2_muabatcuthugilower')}}</p>--}}
{{--<p>{{trans('index.v2_dedangmua')}}</p>--}}
{{--</div>--}}
{{--<div class="col-xs-12 col-sm-6 col-md-2">--}}
{{--<ul class="list_menu_ft">--}}
{{--<li><a href="{{url('blog')}}">{{trans("index.blog")}}</a></li>--}}
{{--<li><a href="{{url('about')}}">{{trans("index.vechungtoi")}}</a></li>--}}
{{--<li><a href="{{url('faq')}}">{{trans("index.cauhoithuonggap")}}</a></li>--}}
{{--<li><a href="{{url('term')}}">{{trans("index.dieukhoansudung")}}</a></li>--}}
{{--<li><a href="{{url('policy')}}">{{trans("index.chinhsachbaomat")}}</a></li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--<div class="col-xs-12 col-sm-6 col-md-2">--}}
{{--<ul class="list_menu_ft">--}}
{{--<li><a href="mailto:info@subsuf.com"><i class="fa fa-commenting" aria-hidden="true"></i>{{trans('index.v2_lienhe')}}</a></li>--}}
{{--<li><a href="https://www.facebook.com/Subsuf.global/?ref=aymt_homepage_panel"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a></li>--}}
{{--<li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></li>--}}
{{--<li><a href="https://www.youtube.com/channel/UCDNkaXLEvRmS1i1_JLAhSIw"><i class="fa fa-youtube-play" aria-hidden="true"></i>--}}
{{--Youtube</a></li>--}}
{{--<li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>Email</a></li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--<div class="col-xs-12 col-sm-6 col-md-2">--}}
{{--<ul class="list_menu_ft ngonngu">--}}
{{--<li><a href="{{url('change-language?language=vi')}}"><img src="{{url('v2/images/icon-lg-vn.png')}}" alt="">Tiếng Việt</a></li>--}}
{{--<li><a href="{{url('change-language?language=en')}}"><img src="{{url('v2/images/icon-lg-anh.png')}}" alt="">Tiếng Anh</a></li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--<div class="col-xs-12 col-sm-6 col-md-3">--}}
{{--<ul class="list_menu_ft thanhtoan">--}}
{{--<li>--}}
{{--<a href="#"><img src="{{url('v2/images/icon-thanhtoan1.png')}}" alt=""></a>--}}
{{--</li>--}}
{{--<li>--}}
{{--<a href="#"><img src="{{url('v2/images/icon-thanhtoan2.png')}}" alt=""></a>--}}
{{--</li>--}}
{{--<li>--}}
{{--<a href="#"><img src="{{url('v2/images/icon-thanhtoan3.png')}}" alt=""></a>--}}
{{--</li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="sub_footer">--}}
{{--<div class="container">--}}
{{--<p>{{trans("index.copyright")}}</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</footer>--}}

<footer class="footer">
    <div class="main_footer">
        <div class="container">
            <div class="row">


                <div class="col-xs-12 col-md-12 mb15">
                    <span class="nhanngay_title "> {{ trans('index.uudai50k') }}</span>
                    <span><input type="text" class="input_nhanngay" size="30"
                                 placeholder="{{trans('index.entermail')}}"/></span>
                    <span><button class="nhanngay">{{trans('index.nhanuudai')}}</button></span>

                    <span class="tticon hidden-xs"><a href="#"><img src="/v2/images/icon-thanhtoan1.png"
                                                                    alt=""></a></span>
                    <span class="hidden-xs"><a href="#"><img src="/v2/images/icon-thanhtoan2.png" alt=""></a></span>
                    <span class="hidden-xs"><a href="#"><img src="/v2/images/icon-thanhtoan3.png" alt=""></a></span>
                </div>
                <div class="col-xs-12 col-md-12 mb15" id="footer_mess">

                </div>

                <div class="col-xs-12 col-md-4">

                    <p><span class="icon"><img src="/v2/images/icon_phone.png"/></span><span
                                class="icontext">{{trans("index.number_phone")}}</span></p>
                    <p><span class="icon"><img src="/v2/images/icon_mail.png"/></span><span
                                class="icontext">support@subsuf.com</span></p>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <ul class="list_menu_ft">
                        <li><a href="{{url('blog')}}">{{trans("index.blog")}}</a></li>
                        <li><a href="{{url('about')}}">{{trans("index.vechungtoi")}}</a></li>
                        <li><a href="{{url('faq')}}">{{trans("index.cauhoithuonggap")}}</a></li>
                        <li><a href="{{url('term')}}">{{trans("index.dieukhoansudung")}}</a></li>
                        <li><a href="{{url('policy')}}">{{trans("index.chinhsachbaomat")}}</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <div class="text-center">

                        <p>{{ trans('index.ketnoichungtoi') }}</p>
                        <p class="kn">
                            <a href="https://www.facebook.com/Subsuf.global/?ref=aymt_homepage_panel"><img
                                        src="/v2/images/fb.png"/> </a>
                            <a href="#"><img src="/v2/images/ln.png"/> </a>
                            <a href="https://www.youtube.com/channel/UCDNkaXLEvRmS1i1_JLAhSIw"><img
                                        src="/v2/images/yt.png"/> </a>
                        </p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="text-center">

                        <p>{{ trans('index.ngonngu') }}</p>
                        <p class="nn">

                            <a href="{{url('change-language?language=vi')}}"><img src="/v2/images/icon-lg-vn.png"
                                                                                  alt=""></a>
                            <a href="{{url('change-language?language=en')}}"><img src="/v2/images/icon-lg-anh.png"
                                                                                  alt=""></a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="sub_footer">
        <div class="container">
            <p>{{trans("index.copyright")}}</p>
        </div>
    </div>
</footer>
