@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/faq.min.css')}}

    <style>
        .faq-content-1 .faq-section {
            background-color: #fff;
            padding: 0 !important;
            margin-bottom: 0 !important;
        }
    </style>
@endsection
@section('breadcrumb')

@endsection

@section('content')
    <div class="container">
        <div class="row margin-top-40 stories-header" data-auto-height="true">
            <div class="col-md-12  text-center">
                <h1>FAQ</h1>
            </div>
        </div>
        <div class="row faq-page faq-content-1">
            <div class="col-lg-10 col-lg-offset-1 col-xs-offset-0">
                <div class="portlet light bordered">
                    <h3 class="text-center font-red">{{trans('index.shopper_faq')}}</h3>
                    <div class="faq-section ">
                        <div class="panel-group accordion faq-content" id="accordion1">
                            @foreach($shopper_faqs as $key => $shopper_faq)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="fa fa-circle font-red"></i>
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1"
                                               href="#collapse_{{$shopper_faq->faq_id}}" style="padding: 0 !important;">
                                                {!! $shopper_faq->ask !!}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_{{$shopper_faq->faq_id}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            {!! $shopper_faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <h3 class="text-center font-red">{{trans('index.traveler_faq')}}</h3>
                    <div class="faq-section ">
                        <div class="panel-group accordion faq-content" id="accordion2">
                            @foreach($traveler_faqs as $key => $traveler_faq)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="fa fa-circle font-red"></i>
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                               href="#collapse_{{$traveler_faq->faq_id}}"
                                               style="padding: 0 !important;">
                                                {!! $traveler_faq->ask !!}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_{{$traveler_faq->faq_id}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            {!! $traveler_faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <h3 class="text-center font-red">{{trans('index.other_faq')}}</h3>
                    <div class="faq-section ">
                        <div class="panel-group accordion faq-content" id="accordion3">
                            @foreach($other_faqs as $key => $other_faq)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="fa fa-circle font-red"></i>
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                               href="#collapse_{{$other_faq->faq_id}}" style="padding: 0 !important;">
                                                {!! $other_faq->ask !!}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_{{$other_faq->faq_id}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            {!! $other_faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection