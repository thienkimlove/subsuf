<div class="portlet light profile-sidebar-portlet ">
    <div class="profile-userpic text-center">

        <img src="{{URL::to($user->avatar)}}" class="img-responsive" alt="">
        <br>
        <a data-toggle="modal" href="#basic" class="btn btn-sm red"><i
                    class="fa fa-pencil"></i> {{trans("index.suaanhdaidien")}}</a>
        <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                {!! Form::open(['action' => 'Frontend\UserController@updateImage', 'method' => 'POST', "data-toggle"=>"validator",'files' => true]) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true"></button>
                        <h4 class="modal-title">{{trans("index.suaanhdaidien")}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control" type="file" name="image" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close
                        </button>
                        <button class="btn red" type="submit">{{trans("index.suaanhdaidien")}}</button>
                    </div>
                </div>
            {{Form::close()}}
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <div class="profile-usertitle">
        <div class="profile-usertitle-name">{{$user->first_name}} {{$user->last_name}}</div>
    </div>

    <div class="profile-userbuttons">

        {{--<button type="button" class="btn btn-circle green btn-sm">Shopper <br>--}}
        {{--</button>--}}
        {{--<button type="button" class="btn btn-circle red btn-sm">Traveler</button>--}}
    </div>
    <div class="profile-usermenu">
        <ul class="nav">
            <li class="{{ Request::is('user/profile') ? 'active' : '' }}">
                <a href="{{URL::action('Frontend\UserController@profile')}}">
                    <i class="icon-user"></i> {{trans("index.thongtincanhan")}} </a>
            </li>
            <li class="{{ Request::is('user/ordered') ? 'active' : '' }}">
                <a href="{{URL::action('Frontend\UserController@ordered')}}">
                    <i class="icon-handbag"></i> {{trans("index.cacdonhangdadat")}} </a>
            </li>
            <li class="{{ Request::is('user/offered') ? 'active' : '' }}">
                <a href="{{URL::action('Frontend\UserController@offered')}}">
                    <i class="icon-handbag"></i> {{trans("index.cacyeucaumuaho")}} </a>
            </li>

            <li class="{{ Request::is('user/user-payment-info') ? 'active' : '' }}">
                <a href="{{URL::action("Frontend\UserController@user_payment_info")}}">
                    <i class="icon-credit-card"></i> {{trans("index.user_payment_info")}}
                </a>
            </li>
            <li class="{{ Request::is('user/invite-friend') ? 'active' : '' }}">
                <a href="{{URL::action("Frontend\UserController@inviteFriend")}}">
                    <i class="icon-share"></i> {{trans("index.moibanbe")}} </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon-tag"></i> {{trans("index.magiamgia")}} </a>
            </li>
            <li>
                <a href="#">
                    <i class="icon-info"></i> {{trans("index.trogiup")}} </a>
            </li>
        </ul>
    </div>
</div>