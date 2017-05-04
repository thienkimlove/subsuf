<?php

namespace App\Http\Controllers\Admin;

use App\Helper\StatusHelper;
use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;
use App\Repositories\CouponRepository;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private $request;
    private $couponRepository;
    private $accountRepository;

    public function __construct(Request $request, CouponRepository $couponRepository, AccountRepository $accountRepository)
    {
        $this->request = $request;
        $this->title = 'Quản lý Coupon';
        $this->couponRepository = $couponRepository;
        $this->accountRepository = $accountRepository;
    }

    public function index()
    {
        $query = [];
        if ($this->request->has('coupon_code')) {
            $coupon_code = trim($this->request->input('coupon_code'));
            $query['coupon_code'] = "coupon_code LIKE '%$coupon_code%'";
        }

        if ($this->request->has('status')) {
            $status = (int)trim($this->request->input('status'));
            $query['status'] = "status = $status";
        }

        if ($this->request->has('account_id')) {
            $account_id = (int)trim($this->request->input('account_id'));
            $query['account_id'] = "account_id = $account_id";
        }

        $coupons = $this->couponRepository->getLimit(30, $query);
        $accounts = $this->accountRepository->getAll();
        $coupon_status = StatusHelper::coupon();

        $response = [
            'title' => $this->title,
            'coupons' => $coupons,
            'accounts' => $accounts,
            'coupon_status' => $coupon_status
        ];

        $this->request->flash();

        return view('admin.coupon.index', $response);
    }

    public function insert()
    {
        $accounts = $this->accountRepository->getAll();
        $response = [
            'title' => $this->title,
            'accounts' => $accounts
        ];

        if ($this->request->isMethod('post')) {
            $validator = coupon_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_coupon_form($this->request);
                    $this->couponRepository->insert($data);

                    return \Redirect::action('Admin\CouponController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }
        return view('admin.coupon.insert', $response);
    }

    public function info($id)
    {
        $coupon = $this->couponRepository->find($id);
        if ($coupon != null) {
            $response = [
                'title' => $this->title,
                'coupon' => $coupon
            ];
            return view('admin.coupon.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function update($id)
    {
        $coupon = $this->couponRepository->find($id);
        if ($coupon != null) {
            $accounts = $this->accountRepository->getAll();
            $response = [
                'title' => $this->title,
                'accounts' => $accounts,
                'coupon' => $coupon
            ];

            if ($this->request->isMethod('post')) {
                $validator = coupon_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_coupon_form($this->request);
                        $this->couponRepository->update($id, $data);
                        return \Redirect::action('Admin\CouponController@index')->withSuccess(message_update());
                    } catch (Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.coupon.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($id)
    {
        if ($this->couponRepository->delete($id)) {
            return \Redirect::action('Admin\CouponController@index');
        }
    }
}
