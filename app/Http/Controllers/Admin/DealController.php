<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\DealRepository;
use Illuminate\Http\Request;

class DealController extends Controller
{
    private $request;
    private $dealRepository;
    private $title;

    public function __construct(Request $request, DealRepository $dealRepository)
    {
        $this->request = $request;
        $this->dealRepository = $dealRepository;
        $this->title = 'Quản lý Popup Khuyến mãi';
    }

    public function index()
    {
        $deals = $this->dealRepository->getLimit(get_limit());

        $response = [
            'title' => $this->title,
            'deals' => $deals,
        ];

        $this->request->flash();

        return view('admin.config-manage.deal.index', $response);
    }

    public function insert()
    {
        $response = [
            'title' => $this->title,
        ];

        if ($this->request->isMethod('post')) {
            $validator = deal_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_deal_form($this->request);
                    $this->dealRepository->insert($data);

                    return \Redirect::action('Admin\DealController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        $this->request->flash();

        return view('admin.config-manage.deal.insert', $response);
    }

    public function update($deal_id)
    {
        $deal = $this->dealRepository->find($deal_id);
        if ($deal != null) {
            $response = [
                'title' => $this->title,
                'deal' => $deal,
            ];

            if ($this->request->isMethod('post')) {
                $validator = deal_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_deal_form($this->request);
                        $this->dealRepository->update($deal_id, $data);

                        return \Redirect::action('Admin\DealController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.config-manage.deal.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($deal_id)
    {
        try {
            if ($this->dealRepository->delete($deal_id)) {
                return \Redirect::action('Admin\DealController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}