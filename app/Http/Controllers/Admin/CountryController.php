<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    private $request;
    private $countryRepository;

    public function __construct(Request $request, CountryRepository $countryRepository)
    {
        $this->request = $request;
        $this->title = 'Danh mục Quốc gia';
        $this->countryRepository = $countryRepository;
    }

    public function index()
    {
        $country = '';
        if ($this->request->has('country')) {
            $country = $this->request->input('country');
        }

        $countries = $this->countryRepository->getLimit(30, $country);

        $response = [
            'title' => $this->title,
            'countries' => $countries
        ];

        $this->request->flashOnly(['country']);

        return view('admin.system_category.country.index', $response);
    }

    public function insert()
    {
        $response = [
            'title' => $this->title,
        ];

        if ($this->request->isMethod('post')) {
            $validator = country_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
            } else {
                try {
                    $data = get_country_form($this->request);
                    $this->countryRepository->insert($data);

                    return \Redirect::action('Admin\CountryController@index');
                } catch (\Exception $exception) {
                    return \Redirect::back();
                }
            }
        }

        return view('admin.system_category.country.insert', $response);
    }

    public function info($id)
    {
        $country = $this->countryRepository->find($id);
        if ($country != null) {
            $response = [
                'title' => $this->title,
                'country' => $country
            ];

            return view('admin.system_category.country.info', $response);
        } else {

        }
    }

    public function update($id)
    {
        $country = $this->countryRepository->find($id);
        if ($country != null) {
            $response = [
                'title' => $this->title,
                'country' => $country
            ];

            if ($this->request->isMethod('post')) {
                $validator = country_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                } else {
                    try {
                        $data = get_country_form($this->request);
                        $this->countryRepository->update($id, $data);

                        return \Redirect::action('Admin\CountryController@index');
                    } catch (\Exception $exception) {
                        return \Redirect::back();
                    }
                }
            }

            return view('admin.system_category.country.update', $response);
        } else {

        }
    }

    public function delete($id)
    {
        if ($this->countryRepository->delete($id)) {
            return \Redirect::action('Admin\CountryController@index');
        }
    }
}
