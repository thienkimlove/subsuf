<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\BlogRepository;
use App\Repositories\BlogCategoryRepository;
use Symfony\Component\HttpFoundation\Request;


class BlogController extends Controller
{
    private $request;
    private $blog;
    private $category;
    private $locale;

    public function __construct(Request $request, BlogRepository $blog, BlogCategoryRepository $category)
    {
        parent::__construct();
        $this->request = $request;
        $this->blog = $blog;
        $this->category = $category;

        $this->locale = \App::getLocale();
        if ($this->locale == '') {
            $this->locale = 'vi';
        }
    }

    public function index()
    {
        $categories = $this->category->getAll(["language = '$this->locale'", "status = 1"]);
        $category_ids = [];
        foreach ($categories as $category) {
            $category_ids[] = $category->category_id;
        }

        $ids = implode(",", $category_ids);

        $blog_list = $this->blog->getLimit(15, [
            'category_id' => "category_id IN ($ids)",
            'is_published' => "is_published = 1"
        ]);

        $response = [
            'title' => 'Blog',
            'categories' => $categories,
            'blog_list' => $blog_list
        ];

        return view('v2.blog.index', $response);
    }

    public function blog_details($blog_slug)
    {
        $chose_blog = $this->blog->findBySlug($blog_slug);
        if ($chose_blog) {
            $response = [
                'title' => $chose_blog->title,
                'chose_blog' => $chose_blog
            ];

            return view('v2.blog.details', $response);
        } else {
            return \Redirect::action('Frontend\BlogController@index');
        }
    }

    public function category($category_slug)
    {
        $chose_category = $this->category->findBySlug($category_slug);
        if ($chose_category) {
            $categories = $this->category->getAll(["language = '$this->locale'", "status = 1"]);
            $blog_list = $this->blog->getLimit(15, [
                'category_id' => "category_id = $chose_category->category_id",
                'is_published' => "is_published = 1"
            ]);

            $response = [
                'title' => $chose_category->name,
                'categories' => $categories,
                'blog_list' => $blog_list,
                'chose_category' => $chose_category
            ];

            return view('v2.blog.index', $response);
        } else {
            return \Redirect::action('Frontend\BlogController@index');
        }
    }
}
