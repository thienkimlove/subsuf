<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;


use App\Helper\StatusHelper;
use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $request;
    private $accountRepository;

    public function __construct(Request $request, AccountRepository $accountRepository)
    {
        $this->request = $request;
        $this->title = 'Quản lý Người dùng';
        $this->accountRepository = $accountRepository;
    }

    public function index()
    {
        $query = [];
        if ($this->request->has('email')) {
            $query['email'] = trim($this->request->input('email'));
        }

        if ($this->request->has('phone_number')) {
            $query['phone_number'] = trim($this->request->input('phone_number'));
        }

        if ($this->request->has('full_name')) {
            $query['full_name'] = trim($this->request->input('full_name'));
        }

        $accounts = $this->accountRepository->getLimit(30, $query);

        $response = [
            'title' => $this->title,
            'accounts' => $accounts,
            'email_status' => StatusHelper::account_front_verified(),
            'account_status' => StatusHelper::account_front()
        ];

        $this->request->flashOnly(['email', 'phone_number', 'full_name']);

        return view('admin.front-manage.account.index', $response);
    }

    public function info($account_id)
    {
        $account = $this->accountRepository->find($account_id);
        if ($account !== null) {
            $response = [
                'title' => $this->title . ' - Tài khoản',
                'account' => $account,
                'account_status' => StatusHelper::account_front(),
                'email_status' => StatusHelper::account_front_verified(),
            ];

            return view('admin.front-manage.account.info', $response);
        } else {
            return \Redirect::back()->withError('Tài khoản không tồn tại');
        }
    }

    public function payment_info($account_id)
    {
        $account = $this->accountRepository->findWithPayment($account_id);

        if ($account !== null) {
            $response = [
                'title' => $this->title . ' - Thanh toán',
                'account' => $account,
                'account_status' => StatusHelper::account_front(),
                'email_status' => StatusHelper::account_front_verified(),
            ];

            return view('admin.front-manage.account.payment_info', $response);
        } else {
            return \Redirect::back()->withError('Tài khoản không tồn tại');
        }
    }

    public function ban($id)
    {
        try {
            $data = ['account_status' => -1];
            $this->accountRepository->update($id, $data);

            return \Redirect::back()->withSuccess('Đã tạm dừng tài khoản');
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }

    public function active($id)
    {
        try {
            $data = ['account_status' => 1];
            $this->accountRepository->update($id, $data);

            return \Redirect::back()->withSuccess('Đã kích hoạt tài khoản');
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}