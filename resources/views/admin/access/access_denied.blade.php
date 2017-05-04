@extends('admin.layout.master')
@section('style')
    {{Html::style('assets/pages/css/error.css')}}
@endsection

@section('breadcrumb')
@endsection
@section('pagetitle', "")
@section('content')
    <div class="row">
        <div class="col-md-12 page-404">
            <div class="details">
                <h1>Không có quyền truy cập</h1>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection