<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ItemRepository;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    private $request;
    private $itemRepository;
    private $categoryRepository;
    private $brandRepository;

    public function __construct(Request $request, ItemRepository $itemRepository,
                                CategoryRepository $categoryRepository, BrandRepository $brandRepository)
    {
        $this->request = $request;
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->title = 'Danh mục Sản phẩm';
    }

    public function index()
    {
        $query = [];

        if ($this->request->has('name')) {
            $name = trim($this->request->input('name'));
            $query['name'] = "name LIKE '%$name%'";
        }

        if ($this->request->has('category_id')) {
            $category_id = (int)trim($this->request->input('category_id'));
            $query['category_id'] = "category_id = $category_id";
        }

        if ($this->request->has('brand_id')) {
            $brand_id = (int)trim($this->request->input('brand_id'));
            $query['brand_id'] = "brand_id = $brand_id";
        }

        if ($this->request->has('is_sale')) {
            $query['is_sale'] = "is_sale = 1";
        }

        if ($this->request->has('featured')) {
            $query['featured'] = "featured = 1";
        }

        $items = $this->itemRepository->getLimit(get_limit(), $query);
        $categories = $this->categoryRepository->getAll();
        $brands = $this->brandRepository->getAll();

        $response = [
            'title' => $this->title,
            'items' => $items,
            'categories' => $categories,
            'brands' => $brands
        ];

        $this->request->flash();

        return view('admin.system_category.item.index', $response);
    }

    public function insert()
    {
        $brands = $this->brandRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        $response = [
            'title' => $this->title,
            'categories' => $categories,
            'brands' => $brands,
        ];

        if ($this->request->isMethod('post')) {
            $validator = item_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_item_form($this->request);
                    $this->itemRepository->insert($data);

                    return \Redirect::action('Admin\ItemController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        return view('admin.system_category.item.insert', $response);
    }

    public function info($id)
    {
        $item = $this->itemRepository->find($id);
        if ($item != null) {
            $response = [
                'title' => $this->title,
                'item' => $item
            ];

            return view('admin.system_category.item.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function update($id)
    {
        $item = $this->itemRepository->find($id);
        if ($item != null) {
            $categories = $this->categoryRepository->getAll();
            $brands = $this->brandRepository->getAll();
            $response = [
                'title' => $this->title,
                'item' => $item,
                'categories' => $categories,
                'brands' => $brands
            ];

            if ($this->request->isMethod('post')) {
                $validator = item_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_item_form($this->request);
                        $this->itemRepository->update($id, $data);

                        return \Redirect::action('Admin\ItemController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.system_category.item.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($id)
    {
        try {
            if ($this->itemRepository->delete($id)) {
                return \Redirect::action('Admin\ItemController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}
