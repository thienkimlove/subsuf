<?php

namespace App\Http\Controllers\Admin;

use App\Helper\StatusHelper;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $request;
    private $categoryRepository;

    public function __construct(Request $request, CategoryRepository $categoryRepository)
    {
        $this->request = $request;
        $this->categoryRepository = $categoryRepository;
        $this->title = 'Danh mục Nhóm hàng hóa';
    }

    public function index()
    {
        $query = [];

        if ($this->request->has('name')) {
            $name = trim($this->request->input('name'));
            $query['name'] = "name LIKE '%$name%'";
        }

        if ($this->request->has('category_type')) {
            $category_type = (int)trim($this->request->input('category_type'));
            $query['category_type'] = "category_type = $category_type";
        }

        $categories = $this->categoryRepository->getLimit(get_limit(), $query);
        $category_types = StatusHelper::category();

        $response = [
            'title' => $this->title,
            'categories' => $categories,
            'category_types' => $category_types
        ];

        $this->request->flash();

        return view('admin.system_category.category.index', $response);
    }

    public function insert()
    {
        $response = [
            'title' => $this->title,
            'category_types' => StatusHelper::category()
        ];

        if ($this->request->isMethod('post')) {
            $validator = category_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_category_form($this->request);
                    $this->categoryRepository->insert($data);

                    return \Redirect::action('Admin\CategoryController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        return view('admin.system_category.category.insert', $response);
    }

    public function info($id)
    {
        $category = $this->categoryRepository->find($id);
        if ($category != null) {
            $response = [
                'title' => $this->title,
                'category' => $category
            ];

            return view('admin.system_category.category.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function update($id)
    {
        $category = $this->categoryRepository->find($id);
        if ($category != null) {
            $response = [
                'title' => $this->title,
                'category' => $category,
                'category_types' => StatusHelper::category()
            ];

            if ($this->request->isMethod('post')) {
                $validator = category_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_category_form($this->request);
                        $this->categoryRepository->update($id, $data);

                        return \Redirect::action('Admin\CategoryController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.system_category.category.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($id)
    {
        try {
            if ($this->categoryRepository->delete($id)) {
                return \Redirect::action('Admin\CategoryController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}
