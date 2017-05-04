<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BankRepository;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

class BankController extends Controller
{
    private $request;
    private $bankRepository;
    private $countryRepository;

    public function __construct(Request $request, BankRepository $bankRepository, CountryRepository $countryRepository)
    {
        $this->request = $request;
        $this->title = 'Danh mục Ngân hàng';
        $this->bankRepository = $bankRepository;
        $this->countryRepository = $countryRepository;
    }

    public function index()
    {
        $query = [];
        if ($this->request->has('bank')) {
            $query['name'] = trim($this->request->input('bank'));
        }

        if ($this->request->has('country_id')) {
            $query['country_id'] = (int)trim($this->request->input('country_id'));
        }

        $banks = $this->bankRepository->getLimit(30, $query);
        $countries = $this->countryRepository->getAll();

        $response = [
            'title' => $this->title,
            'banks' => $banks,
            'countries' => $countries
        ];

        $this->request->flashOnly(['name', 'country_id']);

        return view('admin.system_category.bank.index', $response);
    }

    public function insert()
    {
        $countries = $this->countryRepository->getAll();

        $response = [
            'title' => $this->title,
            'countries' => $countries
        ];

        if ($this->request->isMethod('post')) {
            $validator = bank_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
            } else {
                try {
                    $data = get_bank_form($this->request);
                    $this->bankRepository->insert($data);

                    return \Redirect::action('Admin\BankController@index');
                } catch (\Exception $exception) {
                    return \Redirect::back();
                }
            }
        }

        return view('admin.system_category.bank.insert', $response);
    }

    public function info($id)
    {
        $bank = $this->bankRepository->find($id);
        if ($bank != null) {
            $response = [
                'title' => $this->title,
                'bank' => $bank
            ];

            return view('admin.system_category.bank.info', $response);
        } else {

        }
    }

    public function update($id)
    {
        $bank = $this->bankRepository->find($id);
        if ($bank != null) {
            $countries = $this->countryRepository->getAll();
            $response = [
                'title' => $this->title,
                'bank' => $bank,
                'countries' => $countries
            ];

            if ($this->request->isMethod('post')) {
                $validator = bank_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                } else {
                    try {
                        $data = get_bank_form($this->request);
                        $this->bankRepository->update($id, $data);

                        return \Redirect::action('Admin\BankController@index', $bank->bank_id);
                    } catch (\Exception $exception) {
                        return \Redirect::back();
                    }
                }
            }

            return view('admin.system_category.bank.update', $response);
        } else {

        }
    }

    public function delete($id)
    {
        if ($this->bankRepository->delete($id)) {
            return \Redirect::action('Admin\BankController@index');
        }
    }
}
