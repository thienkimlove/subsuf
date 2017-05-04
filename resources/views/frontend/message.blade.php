@if(Session::has("error"))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                {{Session::get("error")}}
            </div>
        </div>
    </div>
@endif
@if(Session::has("success"))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button>
                {{Session::get("success")}}
            </div>
        </div>
    </div>
@endif
@if(Session::has("warning"))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning">
                <button class="close" data-close="alert"></button>
                {{Session::get("warning")}}
            </div>
        </div>
    </div>
@endif