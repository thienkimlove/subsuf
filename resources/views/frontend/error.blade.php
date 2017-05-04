@extends('frontend.layout.template')
@section('style')
    {{Html::style('assets/pages/css/about.min.css')}}
    {{Html::style('assets/pages/css/blog.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2.min.css')}}
    {{Html::style('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}

    <style>
        .about-header h2, .stories-header h2 {
            letter-spacing: 1px;
            text-transform: none;
        }

        video {
            width: 100% !important;
            height: auto !important;
        }
    </style>
@endsection
@section('breadcrumb')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-top-20">
                <div class="portlet light">
                    <div class="portlet-body text-center">
                        <br>
                        @if(Session::has("error"))
                            <div class="alert alert-danger">{{Session::get("error")}}</div>
                        @endif
                        @if(Session::has("success"))
                            <div class="alert alert-success">{{Session::get("success")}}</div>
                        @endif
                        <p><a href="/" class="btn red">{{trans("index.quaylaitrangchu")}}</a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')


@endsection