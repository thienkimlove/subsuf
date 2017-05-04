<?php
/**
 * Created by PhpStorm.
 * User: truongdt
 * Date: 10/17/2016
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\ExchangeRepository;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    private $request;
    private $exchangeRepository;

    public function __construct(Request $request, ExchangeRepository $exchangeRepository)
    {
        $this->request = $request;
        $this->exchangeRepository = $exchangeRepository;
        $this->title = 'Quản lý Tỷ giá';
    }

    public function index()
    {
        $exchanges = $this->exchangeRepository->getLimit(get_limit());

        $response = [
            'title' => $this->title,
            'exchanges' => $exchanges,
        ];

        $this->request->flash();

        return view('admin.config-manage.exchange.index', $response);
    }

    public function insert()
    {
        $response = [
            'title' => $this->title,
        ];

        if ($this->request->isMethod('post')) {
            $validator = exchange_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_exchange_form($this->request);
                    $this->exchangeRepository->insert($data);

                    return \Redirect::action('Admin\ExchangeController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        $this->request->flash();

        return view('admin.config-manage.exchange.insert', $response);
    }

    public function update($exchange_id)
    {
        $exchange = $this->exchangeRepository->find($exchange_id);
        if ($exchange != null) {
            $response = [
                'title' => $this->title,
                'exchange' => $exchange,
            ];

            if ($this->request->isMethod('post')) {
                $validator = exchange_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_exchange_form($this->request);
                        $this->exchangeRepository->update($exchange_id, $data);

                        return \Redirect::action('Admin\ExchangeController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.config-manage.exchange.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($exchange_id)
    {
        try {
            if ($this->exchangeRepository->delete($exchange_id)) {
                return \Redirect::action('Admin\ExchangeController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}