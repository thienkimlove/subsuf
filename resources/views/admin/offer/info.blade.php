{{Html::style('assets/pages/css/profile.min.css')}}

<div class="portlet box green" style="margin-bottom: 0 !important;">
    <div class="portlet-title">
        <div class="caption text-uppercase">
            Chi tiết Offer #{{$offer->offer_id}}
        </div>
    </div>

    <div class="portlet-body">
        <div class="profile-userpic">
            <img @if($offer->account->avatar == '') src="{{'/assets/pages/media/profile/default_user.jpg'}}"
                 @else src="{{$offer->account->avatar}}" @endif class="img-responsive" alt=""
                 style="max-width: 70px;">
        </div>

        <div class="profile-usertitle">
            <div class="profile-usertitle-name">
                    <span class="full-name" style="font-size: 14px">
                        {{$offer->account->first_name . ' ' . $offer->account->last_name}}
                    </span>
                    <span class="request">
                        đã đề nghị từ {{humanTiming(strtotime($offer->offer_time), 'vi')}}
                    </span>
            </div>
            <div class="profile-usertitle-job"></div>
        </div>

        <div class="table-scrollable table-scrollable-borderless">
            <table class="table table-hover table-light order-detail">
                <tbody>
                <tr>
                    <td width="30%">Thời gian</td>
                    <td align="right" class="bold highlight">
                        {{date('H:i d-m-Y', strtotime($offer->offer_time))}}
                    </td>
                </tr>
                <tr>
                    <td>Từ</td>
                    <td align="right" class="bold highlight">
                        {{$offer->from_location->name}}
                    </td>
                </tr>
                <tr>
                    <td>Ngày đến</td>
                    <td align="right" class="bold highlight">
                        {{date('d-m-Y', strtotime($offer->deliver_date))}}
                    </td>
                </tr>
                <tr>
                    <td>Tổng phí</td>
                    <td align="right" class="bold highlight">
                        {{number_format(($offer->shipping_fee + $offer->tax + $offer->others_fee), 2, '.', ',')}} $
                    </td>
                </tr>
                <tr>
                    <td>Phí ship</td>
                    <td align="right">
                        {{number_format(($offer->shipping_fee), 2, '.', ',')}} $
                    </td>
                </tr>
                <tr>
                    <td>Thuế</td>
                    <td align="right">
                        {{number_format(($offer->tax), 2, '.', ',')}} $
                    </td>
                </tr>
                <tr>
                    <td>Phí khác</td>
                    <td align="right">
                        {{number_format(($offer->others_fee), 2, '.', ',')}} $
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: text-top !important;">Bổ sung</td>
                    <td style="text-align: justify;text-justify: inter-word;font-size: 12px!important;">
                        {{$offer->deliver_details}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>