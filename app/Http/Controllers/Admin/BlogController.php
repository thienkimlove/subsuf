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
use App\Repositories\AdminRepository;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogRepository;
use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $request;
    private $blog;
    private $blogCategory;
    private $language;
    private $admin;

    public function __construct(Request $request, BlogRepository $blog, BlogCategoryRepository $blogCategory,
                                LanguageRepository $language, AdminRepository $admin)
    {
        $this->request = $request;
        $this->title = 'Quản lý Blog';
        $this->blog = $blog;
        $this->blogCategory = $blogCategory;
        $this->language = $language;
        $this->admin = $admin;
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

        if ($this->request->has('title')) {
            $title = trim($this->request->input('title'));
            $query['title'] = "title LIKE '%$title%'";
        }

        if ($this->request->has('category')) {
            $category = (int)trim($this->request->input('category'));
            $query['category'] = "category_id = $category";
        }

        if ($this->request->has('author')) {
            $author = (int)trim($this->request->input('author'));
            $query['author'] = "author_id = $author";
        }

        $languages = $this->language->getAll();
        $blogCategories = $this->blogCategory->getAll();
        $blog_list = $this->blog->getLimit(get_limit(), $query);
        $admins = $this->admin->getAll();
        $blog_status = StatusHelper::blog();

        $response = [
            'title' => $this->title,
            'languages' => $languages,
            'blogCategories' => $blogCategories,
            'blog_list' => $blog_list,
            'admins' => $admins,
            'blog_status' => $blog_status,
        ];

        $this->request->flash();

        return view('admin.blog_manage.blog.index', $response);
    }

    public function insert()
    {
        $languages = $this->language->getAll();
        $blogCategories = $this->blogCategory->getAll();

        if ($this->request->isMethod('post')) {
            $validator = blog_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_blog_form($this->request);
                    $this->blog->insert($data);

                    return \Redirect::action('Admin\BlogController@index')->withSuccess(message_insert());
                } catch (Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        $response = [
            'title' => $this->title,
            'languages' => $languages,
            'blogCategories' => $blogCategories
        ];

        $this->request->flash();

        return view('admin.blog_manage.blog.insert', $response);
    }

    public function update($blog_id)
    {
        $blog = $this->blog->find($blog_id);
        if ($blog !== null) {
            $languages = $this->language->getAll();
            $blogCategories = $this->blogCategory->getAll();

            $response = [
                'title' => $this->title,
                'blog' => $blog,
                'languages' => $languages,
                'blogCategories' => $blogCategories
            ];

            if ($this->request->isMethod('post')) {
                $validator = blog_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_blog_form($this->request);
                        $this->blog->update($blog_id, $data);

                        return \Redirect::action('Admin\BlogController@index')->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.blog_manage.blog.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($blog_id)
    {
        try {
            if ($this->blog->delete($blog_id)) {
                return \Redirect::action('Admin\BlogController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}