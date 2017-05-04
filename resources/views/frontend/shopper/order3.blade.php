@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/cubeportfolio/css/cubeportfolio.css')}}
    {{Html::style('assets/pages/css/portfolio.min.css')}}
    {{Html::style('assets/pages/css/search.min.css')}}
    {{Html::style('assets/global/plugins/icheck/skins/all.css')}}
    <style xmlns="http://www.w3.org/1999/html">
        #orderDetail h2 {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #69717e;
        }

        .content-right {
            font-size: 14px;
            float: right;
            text-transform: none;
        }

        #orderDetail .col-xs-12 h2 {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
    </style>
@endsection
@section('breadcrumb')
    {{--<div class="container">--}}
    {{--<!-- BEGIN PAGE BREADCRUMBS -->--}}
    {{--<ul class="page-breadcrumb breadcrumb">--}}
    {{--<li>--}}
    {{--<a href="index.html">Home</a>--}}
    {{--<i class="fa fa-circle"></i>--}}
    {{--</li>--}}
    {{--<li>--}}
    {{--<span>Layouts</span>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
@endsection

@section('content')

    <div class="container white">
        <div class="row margin-top-40">
            <div class="portlet light">
                <div class="portlet-body form">
                    <span class="hidden-md hidden-lg">{{trans("index.taoyeucau")}}</span>
                    <div class="mt-element-step hidden-sm hidden-xs">
                        <div class="row step-line">
                            <div class="mt-step-desc">
                                <div class="col-md-4 mt-step-col first done">
                                    <div class="mt-step-number bg-white">
                                        <i class="icon-basket"></i>
                                    </div>
                                    <div class="mt-step-title uppercase font-grey-cascade">{{trans("index.thongtinsanpham")}}</div>
                                </div>
                                <div class="col-md-4 mt-step-col done">
                                    <div class="mt-step-number bg-white">
                                        <i class="icon-credit-card"></i>
                                    </div>
                                    <div class="mt-step-title uppercase font-grey-cascade">{{trans("index.chitietgiaohang")}}
                                    </div>
                                </div>
                                <div class="col-md-4 mt-step-col last error">
                                    <div class="mt-step-number bg-white">
                                        <i class="icon-rocket"></i>
                                    </div>
                                    <div class="mt-step-title uppercase font-grey-cascade">{{trans("index.taoyeucau")}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-8 text-center">
                            <hr>
                            <h4>{{trans("index.chitietdonhang")}}
                            </h4>
                            <p>{{trans("index.chitietdonhang_detail")}}</p>
                        </div>
                    </div>
                    {!! Form::open(['action' => 'Frontend\ShopperController@saveOrder', 'method' => 'POST','id'=>'addPlanDetail', 'files' => true,"data-toggle"=>"validator"]) !!}

                    <div class="row form" id="orderDetail">
                        <div class="col-lg-12 margin-top-10">
                            <div class="col-lg-12 margin-bottom-10 margin-top-10 text-center">
                                @foreach($order["images"] as $image)
                                    <img src="{{URL::to($image)}}" style="width: 120px; height: 120px">
                                @endforeach
                            </div>
                            <div class="col-lg-12">
                                <h3 class="invoice-desc"><strong style="font-weight: 600">{{$order["name"]}}</strong>
                                </h3>
                            </div>
                            <div class="col-xs-12">
                                <p class="invoice-desc">{{$order["description"]}}</p>
                            </div>
                            <div class="col-xs-12">
                                <h2 class="invoice-title uppercase">{{trans("index.den")}} <span
                                            class="content-right font-red"><p>{{($deliver_to)?$deliver_to->name:""}}</p></span>
                                </h2>
                            </div>
                            @if(isset($order2["deliver_from"]))
                                <div class="col-xs-12" style="border: none">
                                    <h2 class="invoice-title uppercase">{{trans("index.tu")}}
                                        <span class="content-right font-red">
                                            <p>{{($deliver_from)?$deliver_from->name:trans("index.batkydau")}}</p>
                                        </span>
                                    </h2>
                                </div>
                            @endif

                            @if($order2["deliver_date"])
                                <div class="col-xs-12" style="border: none">
                                    <h2 class="invoice-title uppercase">{{trans("index.ngaygiaohang")}}
                                        <span class="content-right font-red">
                                            <p>{{date("d-m-Y", strtotime($order2["deliver_date"]))}}</p>
                                        </span>
                                    </h2>
                                </div>
                            @endif
                            {{--<div class="col-xs-12">--}}
                            {{--<h2 class="invoice-title uppercase">Mô tả thêm </h2>--}}
                            {{--<div class="form-group">--}}
                            {{--<textarea name="item_detail" class="form-control"--}}
                            {{--placeholder="Add Item detail or comment to traveler"></textarea>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="col-xs-12">
                                <h2 class="invoice-title uppercase">{{trans("index.tiencongngmuaho")}}<span
                                            class="content-right font-red"><p>${{number_format($order2["input-reward"], 2)}}
                                            </p></span></h2>
                            </div>
                            <div class="col-xs-12">
                                <h2 class="invoice-title uppercase">
                                    {{trans("index.giasanpham")}}
                                    <span
                                            class="content-right font-red">
                                        <p>{{$order["quantity"]}} x ${{number_format($order["price"],2)}} </p>
                                    </span>
                                </h2>
                            </div>

                            <div class="col-xs-12">
                                <h2 class="invoice-title uppercase">
                                    {{trans("index.phidichvu")}} <a class="popovers" data-container="body"
                                                                    data-content="{!! trans("index.detailphidichvu") !!}"
                                                                    data-html="true"
                                                                    data-original-title="{{trans("index.cachtinhphidichvu")}}"><i
                                                class="fa fa-question-circle fa-blue"></i> </a>
                                    <span class="content-right font-red"
                                    ><p>${{number_format($fee,2)}} </p>
                                    </span>
                                </h2>
                            </div>
                            <div class="col-lg-12" style="border: none">
                                <h2 class="invoice-title uppercase">
                                    {{trans("index.tongtien")}}
                                    <span class="content-right font-red">
                                        <b style="font-size: 20px">${{number_format($total,2)}}
                                            </b>
                                    </span>
                                </h2>
                            </div>
                            {{--<div class="col-lg-12 text-center"--}}
                            {{--style="background: #eee; padding: 10px; margin-top: 20px; margin-bottom: 20px">--}}
                            {{--By creating a grab, I agree to <a href="#">Shopper's Terms</a> .--}}
                            {{--</div>--}}
                            <hr>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <a href="{{URL::action("Frontend\ShopperController@order")}}"
                                                   class="btn btn-default btn-circle btn"> <i
                                                            class="fa fa-arrow-left"></i> {{trans("index.quaylai")}}
                                                </a>
                                            </div>
                                            <div class="col-xs-6  text-right">
                                                <button type="submit"
                                                        class="btn btn-circle green btn">{{trans("index.tieptuc")}} <i
                                                            class="fa fa-arrow-right"></i></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-info">
                                    {{trans("index.dambaoantoanchonguoimuaho")}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{Html::script('assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')}}
    {{Html::script('assets/pages/scripts/portfolio-1.min.js')}}
    {{Html::script('assets/global/plugins/icheck/icheck.min.js')}}
    <script type="text/javascript">


    </script>
@endsection