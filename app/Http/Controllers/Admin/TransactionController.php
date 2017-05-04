<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;

use App\Account;
use App\Helper\StatusHelper;
use App\Helper\TransactionHelper;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Order;
use App\OrderImage;
use App\Repositories\LocationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TransactionRepository;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $request;
    private $transactionRepository;

    public function __construct(Request $request, TransactionRepository $transactionRepository, OrderRepository $order, LocationRepository $location)
    {
        $this->request = $request;
        $this->title = 'Quản lý Giao dịch';
        $this->transactionRepository = $transactionRepository;
        $this->order = $order;
        $this->location = $location;
    }

    public function index()
    {
        $start = get_first_day_of_this_month();
        $end = date("Y-m-d");
        if ($this->request->has('start')) {
            $start = $this->request->input('start');
        }

        if ($this->request->has('end')) {
            $end = $this->request->input('end');
        }

        $query = [];
        if ($this->request->has('transaction_id')) {
            $transaction_id = (int)trim($this->request->input('transaction_id'));
            $query['transaction_id'] = "transaction_id = $transaction_id";
        }

        if ($this->request->has('transaction_date')) {
            $transaction_date = trim($this->request->input('transaction_date'));
            $query['transaction_date'] = "transaction_date = '$transaction_date'";

            $transaction_month = date('Y-m', strtotime($transaction_date));
            if ($transaction_month != date('Y-m')) {
                $start = "$transaction_month-01";
                $end = date('Y-m-t', strtotime($transaction_month));
            }
        } else {
            $query['request_time'] = "transaction_date >= '$start' AND transaction_date <= '$end'";
        }

        if ($this->request->has('transaction_status')) {
            $transaction_status = (int)trim($this->request->input('transaction_status'));
            $query['transaction_status'] = "transaction_status = $transaction_status";
        }

        $transactions = $this->transactionRepository->getLimit(get_limit(), $query);
        $transaction_status = StatusHelper::transaction();

        $unlimited_transactions = $this->transactionRepository->getAll($query);
        $statistics = TransactionHelper::transaction_index($unlimited_transactions);

        $response = [
            'title' => $this->title,
            'transactions' => $transactions,
            'transaction_status' => $transaction_status,
            'start' => $start,
            'end' => $end,
            'max' => date('Y-m-d'),
            'statistics' => $statistics
        ];

        $this->request->flash();

        return view('admin.transaction.index', $response);
    }

    public function info($transaction_id)
    {
        $transaction = $this->transactionRepository->find($transaction_id);

        if ($transaction !== null) {
            $response = [
                'title' => $this->title,
                'transaction' => $transaction,
                'offer' => $transaction->offer,
                'order' => $transaction->offer->order,
                'transaction_status' => StatusHelper::transaction()
            ];

            return view('admin.transaction.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function fakeTransaction()
    {
        $users = Account::orderBy("email")->get();
        $location = $this->location->getAll();
        $countrySelect = [null => "Điểm xuất phát"];
        $proviceSelect = [null => "Điểm đến"];
        foreach ($location as $item) {
            if ($item->type == 1)
                $proviceSelect[$item->location_id] = $item->name;
            else
                $countrySelect[$item->location_id] = $item->name;
        }
        $response = [
            'title' => "Fake giao dịch",
            "accounts" => $users,
            "country" => $countrySelect,
            "province" => $proviceSelect
        ];

        return view('admin.transaction.fake', $response);
    }

    public function dofakeTransaction()
    {
        $order = new Order();
        $order->shopper_id = $this->request->input("shopper_id");
        $order->deliver_date = date("Y-m-d", strtotime($this->request->input("deliver_date"))); // ngày nhận dự kiến
        $order->deliver_from = (int)$this->request->input("deliver_from"); // nơi nhận
        $order->deliver_to = (int)$this->request->input("deliver_to");
        $order->link = $this->request->input("link");
        $order->name = $this->request->input("name");
        $order->description = $this->request->input("description");
        $order->price = (float)$this->request->input("price");
        $order->quantity = (int)$this->request->input("quantity");
        $order->traveler_reward = (float)$this->request->input("traveler_reward");
        $order->received_time = date("Y-m-d H:i:s", strtotime($this->request->input("deliver_date"))); // ngày nhận thực tế
        $order->order_status = 3;
        $order->save();

        $image = $this->order->uploadOrderImage($this->request->file('image'));

        $orderImage = new OrderImage();
        $orderImage->order_id = $order->order_id;
        $orderImage->image = $image;
        $orderImage->save();

        $offer = new Offer();
        $offer->order_id = $order->order_id;
        $offer->traveler_id = $this->request->input("traveler_id");
        $offer->offer_status = 3;
        $offer->deliver_date = date("Y-m-d", strtotime($this->request->input("deliver_date"))); // ngày nhận dự kiến
        $offer->deliver_from = (int)$this->request->input("deliver_from_traveler"); // nơi mua hàng
        $offer->shipping_fee = (float)$this->request->input("shipping_fee");
        $offer->tax = (float)$this->request->input("tax");
        $offer->others_fee = (float)$this->request->input("others_fee");
        $offer->payment_type = "bank";
        $offer->payment_info_id = 0;
        $offer->save();

        $total_order = $offer->shipping_fee + $offer->tax + $offer->others_fee + ($order->price * $order->quantity);

        $transaction = new Transaction();
        $transaction->offer_id = $offer->offer_id;
        $transaction->coupon_id = 0;
        $transaction->service_fee = $offer->shipping_fee + $offer->tax + $offer->others_fee;
        $transaction->total = round($total_order * (1 + get_service_percent($total_order)), 2);
        $transaction->service_fee = round($total_order * get_service_percent($total_order), 2);
        $transaction->transaction_date = date("Y-m-d", strtotime($this->request->input("transaction_date"))); // ngày shopper chấp nhận yêu cầu của traveler
        $transaction->transaction_time = date("Y-m-d H:i:s", strtotime($this->request->input("transaction_date"))); // ngày shopper chấp nhận yêu cầu của traveler
        $transaction->transaction_status = 3;
        $transaction->received_time = date("Y-m-d H:i:s", strtotime($this->request->input("received_time"))); // ngày nhận thực tế;
        $transaction->payment_type = "bank";
        $transaction->payment_id = 0;
        $transaction->exchange = 23000;
        $transaction->is_fake = 1; //
        $transaction->save();

        return \Redirect::back()->withSuccess("Đã tạo");

    }

    public function removeTransaction($id)
    {
        $transaction = Transaction::where("transaction_id", $id)->first();
        Order::where("order_id",$transaction->offer->order_id)->delete();
        Offer::where("offer_id",$transaction->offer_id)->delete();
        Transaction::where("transaction_id", $id)->delete();
        return \Redirect::back()->withSuccess("Đã xóa");
    }
}