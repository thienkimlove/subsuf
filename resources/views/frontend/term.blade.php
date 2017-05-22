@extends('v2.template')

@section('content')
    <div class="container">
        <div class="row margin-top-40 stories-header" data-auto-height="true">
            <div class="col-md-12  text-center">
                <h1>{{$term->title}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 col-xs-offset-0">
                <div class="portlet light bordered">
                    {!! $term->content !!}
                </div>
            </div>
        </div>
    </div>

@endsection
