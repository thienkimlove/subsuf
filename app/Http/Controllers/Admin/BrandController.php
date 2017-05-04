<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $request;
    private $brandRepository;

    public function __construct(Request $request, BrandRepository $brandRepository)
    {
        $this->request = $request;
        $this->brandRepository = $brandRepository;
        $this->title = 'Danh mục Thương hiệu';
    }

    public function index()
    {
        $query = [];

        if ($this->request->has('name')) {
            $name = trim($this->request->input('name'));
            $query['name'] = "name LIKE '%$name%'";
        }

        $brands = $this->brandRepository->getLimit(get_limit(), $query);

        $response = [
            'title' => $this->title,
            'brands' => $brands
        ];

        $this->request->flash();

        return view('admin.system_category.brand.index', $response);
    }

    public function insert()
    {
        $response = [
            'title' => $this->title
        ];

        if ($this->request->isMethod('post')) {
            $validator = brand_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_brand_form($this->request);
                    $this->brandRepository->insert($data);

                    return \Redirect::action('Admin\BrandController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        return view('admin.system_category.brand.insert', $response);
    }

    public function info($id)
    {
        $brand = $this->brandRepository->find($id);
        if ($brand != null) {
            $response = [
                'title' => $this->title,
                'brand' => $brand
            ];

            return view('admin.system_category.brand.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function update($id)
    {
        $brand = $this->brandRepository->find($id);
        if ($brand != null) {
            $response = [
                'title' => $this->title,
                'brand' => $brand
            ];

            if ($this->request->isMethod('post')) {
                $validator = brand_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_brand_form($this->request);
                        $this->brandRepository->update($id, $data);

                        return \Redirect::action('Admin\BrandController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.system_category.brand.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($id)
    {
        try {
            if ($this->brandRepository->delete($id)) {
                return \Redirect::action('Admin\BrandController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}
