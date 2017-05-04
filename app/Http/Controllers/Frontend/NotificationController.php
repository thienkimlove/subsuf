<?php

namespace App\Http\Controllers\Frontend;

use App\Coupon;
use App\Helper\NL_Checkout;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Order;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FrontendLoginRepository;
use App\Repositories\ItemRepository;
use App\Repositories\LocationRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OrderRepository;
use App\Transaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends Controller
{
    private $request;
    private $notification;

    public function __construct(Request $request, NotificationRepository $notification)
    {        parent::__construct();

        $this->request = $request;
        $this->notification = $notification;
    }

    public function user_notification($user_id)
    {
        $query['to_user_id'] = $user_id;
        $notifications = $this->notification->getLimit(30, $query);

        $response = [
            'title' => trans("index.thongbao"),
            'notifications' => $notifications
        ];

        return view('frontend.notification.user_notification', $response);
    }
}
