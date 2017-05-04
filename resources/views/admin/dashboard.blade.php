@extends('admin.layout.master')
@section('style')
@endsection

@section('page-breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="#"><i class="fa fa-home"></i></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Previous</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span class="bold">Current</span>
        </li>
    </ul>
@endsection

@section('page-toolbar')
    <div class="page-toolbar">
        <div class="pull-right">
            <a type="button" class="btn green btn-sm uppercase" href="#">
                <i class="fa fa-plus"></i>
                ACTION
            </a>
        </div>
    </div>
@endsection

@section('pagetitle')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-check font-green"></i>
                        <span class="caption-subject font-green bold uppercase">TITLE</span>
                    </div>
                </div>

                <div class="portlet-body"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection