<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\WebsiteRepository;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    private $request;
    private $websiteRepository;
    private $locationRepository;
    private $categoryRepository;

    public function __construct(Request $request, WebsiteRepository $websiteRepository,
                                LocationRepository $locationRepository, CategoryRepository $categoryRepository)
    {
        $this->request = $request;
        $this->websiteRepository = $websiteRepository;
        $this->locationRepository = $locationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->title = 'Danh mục Website';
    }

    public function index()
    {
        $query = [];

        if ($this->request->has('name')) {
            $name = trim($this->request->input('name'));
            $query['name'] = "name LIKE '%$name%'";
        }

        if ($this->request->has('location_id')) {
            $location_id = (int)trim($this->request->input('location_id'));
            $query['location_id'] = "location_id = $location_id";
        }

        if ($this->request->has('category_id')) {
            $category_id = (int)trim($this->request->input('category_id'));
            $query['category_id'] = "category_id = $category_id";
        }

        $websites = $this->websiteRepository->getLimit(get_limit(), $query);
        $locations = $this->locationRepository->getAll(['type' => get_nation()]);
        $categories = $this->categoryRepository->getAll();

        $response = [
            'title' => $this->title,
            'websites' => $websites,
            'locations' => $locations,
            'categories' => $categories
        ];

        $this->request->flash();

        return view('admin.system_category.website.index', $response);
    }

    public function insert()
    {
        $locations = $this->locationRepository->getAll(['type' => get_nation()]);
        $categories = $this->categoryRepository->getAll();
        $response = [
            'title' => $this->title,
            'locations' => $locations,
            'categories' => $categories
        ];

        if ($this->request->isMethod('post')) {
            $validator = website_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_website_form($this->request);
                    $this->websiteRepository->insert($data);

                    return \Redirect::action('Admin\WebsiteController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        return view('admin.system_category.website.insert', $response);
    }

    public function info($id)
    {
        $website = $this->websiteRepository->find($id);
        if ($website != null) {
            $response = [
                'title' => $this->title,
                'website' => $website
            ];

            return view('admin.system_category.website.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function update($id)
    {
        $website = $this->websiteRepository->find($id);
        if ($website != null) {
            $locations = $this->locationRepository->getAll(['type' => get_nation()]);
            $categories = $this->categoryRepository->getAll();
            $response = [
                'title' => $this->title,
                'website' => $website,
                'locations' => $locations,
                'categories' => $categories
            ];

            if ($this->request->isMethod('post')) {
                $validator = website_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_website_form($this->request);
                        $this->websiteRepository->update($id, $data);

                        return \Redirect::action('Admin\WebsiteController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.system_category.website.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($id)
    {
        try {
            if ($this->websiteRepository->delete($id)) {
                return \Redirect::action('Admin\WebsiteController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}
