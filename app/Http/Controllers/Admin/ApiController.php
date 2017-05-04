<?php

namespace App\Http\Controllers\Admin;

use App\Helper\MessageHelper;
use App\Helper\UrlHelper;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Order;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $request;

    public function __construct(Request $request, NotificationRepository $notification)
    {
        $this->request = $request;
        $this->notification = $notification;
    }

    public function url_hint()
    {
        $url = "";
        if ($this->request->has('url')) {
            $url = $this->request->input('url');
        }

        return UrlHelper::crawl($url);
    }

    public function test_send_email()
    {
        try {
            $order = Order::where('order_id', 16)->first();
            $offer = Offer::where('offer_id', 19)->first();

            //Create Shopper Received Order to Traveler Notification
            $data = get_notification($order, $offer,
                MessageHelper::shopper_received(), MessageHelper::shopper_received('en'), 'shopper_received');
//                echo \GuzzleHttp\json_encode($data);die;
            $notification_id = $this->notification->insert($data);
            $notification = $this->notification->find($notification_id);

            //send mail
            send_mail($notification, 'shopper_received');
        } catch (\Exception $e) {
        }

//        Mail::raw('Test Email', function ($message) {
//            $message->to("truongdt.511@gmail.com");
//            $message->subject("Subsuf.com Test email");
//        });
    }
}
