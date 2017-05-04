<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;


use App\Helper\OrderHelper;
use App\Helper\StatusHelper;
use App\Http\Controllers\Controller;
use App\Repositories\LanguageRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $request;
    private $orderRepository;
    private $locationRepository;
    private $offerRepository;

    public function __construct(Request $request, OrderRepository $orderRepository,
                                LanguageRepository $locationRepository, OfferRepository $offerRepository)
    {
        $this->request = $request;
        $this->title = 'Quản lý Order';
        $this->orderRepository = $orderRepository;
        $this->locationRepository = $locationRepository;
        $this->offerRepository = $offerRepository;
    }

    public function index()
    {
        $is_advance = (int)$this->request->input('is_advance', 0);
        $start = get_first_day_of_this_month();
        $end = date("Y-m-d");
        if ($this->request->has('start')) {
            $start = $this->request->input('start');
        }

        if ($this->request->has('end')) {
            $end = $this->request->input('end');
        }

        $query = [];
        if ($this->request->has('order_id')) {
            $order_id = (int)trim($this->request->input('order_id'));
            $query['order_id'] = "order_id = $order_id";
        }

        if ($this->request->has('deliver_from')) {
            $deliver_from = (int)trim($this->request->input('deliver_from'));
            if ($deliver_from != -1) {
                $query['deliver_from'] = "deliver_from = $deliver_from";
            }
        }

        if ($this->request->has('deliver_to')) {
            $deliver_to = (int)trim($this->request->input('deliver_to'));
            if ($deliver_to != -1) {
                $query['deliver_to'] = "deliver_to = $deliver_to";
            }
        }

        if ($this->request->has('deliver_date')) {
            $deliver_date = trim($this->request->input('deliver_date'));
            $query['deliver_date'] = "deliver_date = '$deliver_date'";

            $deliver_month = date('Y-m', strtotime($deliver_date));
            if ($deliver_month != date('Y-m')) {
                $start = "$deliver_month-01";
                $end = date('Y-m-t', strtotime($deliver_month));
            }
        } else {
            $query['request_time'] = "request_time >= '$start' AND request_time <= '$end 23:59:59'";
        }

        if ($this->request->has('order_status')) {
            $order_status = (int)trim($this->request->input('order_status'));
            if ($order_status != -100) {
                $query['order_status'] = "order_status = $order_status";
            }
        }

        if ($this->request->has('email')) {
            $query['email'] = trim($this->request->input('email'));
        }

        if ($this->request->has('link')) {
            $link = trim($this->request->input('link'));
            $query['link'] = "link LIKE '%$link%'";
        }

        $orders = $this->orderRepository->getLimit(30, $query);
        $from_location = $this->locationRepository->getAll(['type' => 0]);
        $to_location = $this->locationRepository->getAll(['type' => 1]);

        $unlimited_orders = $this->orderRepository->getAll($query);
        $statistics = OrderHelper::order_index($unlimited_orders);

        $response = [
            'title' => $this->title,
            'orders' => $orders,
            'order_status' => StatusHelper::order(),
            'from_location' => $from_location,
            'to_location' => $to_location,
            'is_advance' => $is_advance,
            'start' => $start,
            'end' => $end,
            'max' => date('Y-m-d'),
            'statistics' => $statistics
        ];

        $this->request->flash();

        return view('admin.order.index', $response);
    }

    public function info($order_id)
    {
        $order = $this->orderRepository->find($order_id);
        if ($order !== null) {
            $offers = $this->offerRepository->findByOrder($order_id);

            $response = [
                'title' => $this->title,
                'order' => $order,
                'offers' => $offers
            ];

            return view('admin.order.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }
}