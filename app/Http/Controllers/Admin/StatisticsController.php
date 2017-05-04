<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;


use App\Helper\LocationHelper;
use App\Helper\StatisticsHelper;
use App\Helper\StatusHelper;
use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;
use App\Repositories\LocationRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    private $request;
    private $accountRepository;
    private $orderRepository;
    private $locationRepository;
    private $transactionRepository;
    private $offerRepository;

    public function __construct(Request $request, AccountRepository $accountRepository,
                                TransactionRepository $transactionRepository, OfferRepository $offerRepository,
                                OrderRepository $orderRepository, LocationRepository $locationRepository)
    {
        $this->request = $request;
        $this->accountRepository = $accountRepository;
        $this->orderRepository = $orderRepository;
        $this->locationRepository = $locationRepository;
        $this->transactionRepository = $transactionRepository;
        $this->offerRepository = $offerRepository;
    }

    public function order_by_user()
    {
        $accounts = $this->accountRepository->getAll();
        $start = get_first_day_of_this_month();
        $end = date("Y-m-d");
        if ($this->request->has('start')) {
            $start = $this->request->input('start');
        }

        if ($this->request->has('end')) {
            $end = $this->request->input('end');
        }

        $response = [
            'title' => 'Thống kê theo Người dùng',
            'start' => $start,
            'end' => $end,
            'max' => date('Y-m-d'),
            'accounts' => $accounts,
            'account_id' => 0
        ];

        if ($this->request->has('account_id')) {
            $account_id = (int)$this->request->input('account_id');
            $account = $this->accountRepository->findWithOrders($account_id, $start, $end);
            $orders = $account->orders;
            $statistics = StatisticsHelper::order_by_user($orders);
            $response['statistics'] = $statistics;
            $response['selected_account'] = $account;
            $response['account_id'] = $account_id;
        }

        $this->request->flash();

        return view('admin.statistics.order_by_user', $response);
    }

    public function order_by_location()
    {
        $query = [];
        $location_ids = [];
        if ($this->request->has('location_id')) {
            $tmp_location = $this->request->input('location_id');
            foreach (explode(',', $tmp_location) as $item) {
                array_push($location_ids, $item);
            }
        } else {
            $location_ids = [3, 4, 5];
        }

        $ids = implode(",", $location_ids);

        $start = get_first_day_of_this_month();
        $end = date("Y-m-d");
        if ($this->request->has('start')) {
            $start = $this->request->input('start');
        }

        if ($this->request->has('end')) {
            $end = $this->request->input('end');
        }

        $query['to_location'] = "deliver_to IN ($ids)";
        $query['request_time'] = "request_time >= '$start' AND request_time <= '$end 23:59:59'";

        $orders = $this->orderRepository->getAll($query);
        $statistics = StatisticsHelper::order_by_location($orders);

        $locations = LocationHelper::group_by_id($this->locationRepository->getAll(['type' => get_city()]));

        $response = [
            'title' => 'Thống kê theo Địa điểm',
            'start' => $start,
            'end' => $end,
            'max' => date('Y-m-d'),
            'locations' => $locations,
            'location_ids' => $location_ids,
            'ids' => $ids,
            'statistics' => $statistics
        ];
        return view('admin.statistics.order_by_location', $response);
    }

    public function revenue_of_traveler()
    {
        $accounts = $this->accountRepository->getAll();
        $start = get_first_day_of_this_month();
        $end = date("Y-m-d");
        if ($this->request->has('start')) {
            $start = $this->request->input('start');
        }

        if ($this->request->has('end')) {
            $end = $this->request->input('end');
        }

        $response = [
            'title' => 'Doanh thu Traveler',
            'start' => $start,
            'end' => $end,
            'max' => date('Y-m-d'),
            'accounts' => $accounts,
            'account_id' => 0,
        ];

        if ($this->request->has('account_id')) {
            $account_id = (int)$this->request->input('account_id');
            $account = $this->accountRepository->find($account_id);
            $transactions = $this->transactionRepository->getSuccessByAccount($account_id, $start, $end);
            $transaction_status = StatusHelper::transaction();
            $statistics = StatisticsHelper::revenue_traveler($transactions, $start, $end);

            $response['statistics'] = $statistics;
            $response['transaction_status'] = $transaction_status;
            $response['transactions'] = $transactions;
            $response['selected_account'] = $account;
            $response['account_id'] = $account_id;
        }

        $this->request->flash();

        return view('admin.statistics.revenue_traveler', $response);
    }

    public function revenue()
    {
        $query = [];
        $start = get_first_day_of_this_month();
        $end = date("Y-m-d");
        if ($this->request->has('start')) {
            $start = $this->request->input('start');
        }

        if ($this->request->has('end')) {
            $end = $this->request->input('end');
        }

        $query['transaction_date'] = "transaction_date >= '$start' AND transaction_date <= '$end'";
        $query['transaction_status'] = "transaction_status IN (2,3)";
        $transactions = $this->transactionRepository->getAll($query);
        $transaction_status = StatusHelper::transaction();
        $statistics = StatisticsHelper::revenue($transactions, $start, $end);

        $response = [
            'title' => 'Thống kê Doanh thu',
            'start' => $start,
            'end' => $end,
            'max' => date('Y-m-d'),
            'statistics' => $statistics,
            'transactions' => $transactions,
            'transaction_status' => $transaction_status,
        ];

        return view('admin.statistics.revenue', $response);
    }
}