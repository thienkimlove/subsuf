
<div class="modal fade" id="coupon_popup" tabindex="-1" role="basic" aria-hidden="true">
    @if ($deal = \App\Deal::latest('created_at')->get())
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{!!  trans("index.welcomepopuptitle")!!}</h4>
            </div>
            <div class="modal-body">
                <h4>{{$deal->first()->title}}</h4>

                <div class="form-group">
                    <img src="{{ $deal->first()->image  }}" />
                </div>

                <div class="form-group">
                    {{$deal->first()->desc}}
                </div>

                <div class="form-group">
                    <i>Email</i>
                    <input type="text" name="email" id="coupon_email" value="" />
                </div>
                <div class="form-group">
                    <button id="coupon_submit">Get</button>
                </div>

                 <span style="display: none" id="coupon_message"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    @endif
</div>