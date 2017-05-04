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
use App\Repositories\BlogCategoryRepository;
use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    private $request;
    private $blogCategory;
    private $language;

    public function __construct(Request $request, BlogCategoryRepository $blogCategory, LanguageRepository $language)
    {
        $this->request = $request;
        $this->title = 'Quản lý Blog: Thể loại';
        $this->blogCategory = $blogCategory;
        $this->language = $language;
    }

    public function index()
    {
        $query = [];
        if ($this->request->has('language')) {
            $language = trim($this->request->input('language'));
            if ($language != "") {
                $query['language'] = "language = '$language'";
            }
        }

        if ($this->request->has('name')) {
            $name = trim($this->request->input('name'));
            $query['name'] = "name LIKE '%$name%'";
        }

        $blogCategories = $this->blogCategory->getLimit(get_limit(), $query);
        $category_status = StatusHelper::blog_category();
        $languages = $this->language->getAll();

        $response = [
            'title' => $this->title,
            'blogCategories' => $blogCategories,
            'category_status' => $category_status,
            'languages' => $languages
        ];

        $this->request->flash();

        return view('admin.blog_manage.category.index', $response);
    }

    public function insert()
    {
        $languages = $this->language->getAll();

        $response = [
            'title' => $this->title,
            'languages' => $languages
        ];

        if ($this->request->isMethod('post')) {
            $validator = blog_category_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_blog_category_form($this->request);
                    $this->blogCategory->insert($data);

                    return \Redirect::action('Admin\BlogCategoryController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        return view('admin.blog_manage.category.insert', $response);
    }

    public function update($category_id)
    {
        $blog_category = $this->blogCategory->find($category_id);
        if ($blog_category != null) {
            $response = [
                'title' => $this->title,
                'blog_category' => $blog_category,
                'languages' => $languages = $this->language->getAll()
            ];

            if ($this->request->isMethod('post')) {
                $validator = blog_category_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_blog_category_form($this->request);
                        $this->blogCategory->update($category_id, $data);

                        return \Redirect::action('Admin\BlogCategoryController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.blog_manage.category.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function hide($category_id)
    {
        try {
            $data = ['status' => 0];
            $this->blogCategory->update($category_id, $data);

            return \Redirect::back()->withSuccess(message_update());
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }

    public function show($category_id)
    {
        try {
            $data = ['status' => 1];
            $this->blogCategory->update($category_id, $data);

            return \Redirect::back()->withSuccess(message_update());
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }

    public function delete($category_id)
    {
        try {
            if ($this->blogCategory->delete($category_id)) {
                return \Redirect::action('Admin\BlogCategoryController@index')->withSuccess(message_delete());
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}