@extends('v2.template')

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
