<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\CategoryHelper;
use App\Http\Controllers\Controller;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ItemRepository;
use App\Repositories\LocationRepository;
use App\Repositories\WebsiteRepository;
use Symfony\Component\HttpFoundation\Request;

class CollectionsController extends Controller
{
    public function __construct(Request $request, CategoryRepository $category, ItemRepository $item,
                                LocationRepository $location, WebsiteRepository $website, BrandRepository $brand)
    {
        parent::__construct();
        $this->request = $request;
        $this->category = $category;
        $this->location = $location;
        $this->website = $website;
        $this->brand = $brand;
        $this->item = $item;
    }

    public function buy_where()
    {
        $buy_where = $this->category->getWithWebsites()->toArray();
//        usort($buy_where, function ($a, $b) {
//            if (count($a['websites']) === count($b['websites'])) return 0;
//            return (count($a['websites']) < count($b['websites'])) ? 1 : -1;
//        });

        $response = [
            'title' => trans("index.muagiodau"),
            'buy_where' => $buy_where
        ];
        return view('frontend.collections.buy_where', $response);
    }

    public function detail_buy_where($category_id)
    {
        $category = $this->category->find($category_id);
        if ($category != null) {
            $response = [
                'title' => trans("index.muagiodau"),
                'category' => $category
            ];
            return view('frontend.collections.detail_buy_where', $response);
        } else {
            return \Redirect::back();
        }
    }

    public function where_buy()
    {
        $where_buy = $this->location->getWithWebsites()->toArray();
        usort($where_buy, function ($a, $b) {
            if (count($a['websites']) === count($b['websites'])) return 0;
            return (count($a['websites']) < count($b['websites'])) ? 1 : -1;
        });

        $response = [
            'title' => trans("index.quocgia"),
            'where_buy' => $where_buy
        ];
        return view('frontend.collections.where_buy', $response);
    }

    public function detail_where_buy($location_id)
    {
        $location = $this->location->find($location_id);

        if ($location != null) {
            $category_location = $this->website->distinctCategory($location_id);
            $raw_categories = $this->category->getAll(['category_type = 1']);
            $categories = CategoryHelper::group_by_id($raw_categories);

            $query_category = '';
            $arr_category = [];

            if ($this->request->has('category')) {
                $query_category = $this->request->input('category');
                $arr_category = explode(',', $query_category);
            }

            $response = [
                'title' => trans("index.quocgia"),
                'location' => $location,
                'category_location' => $category_location,
                'categories' => $categories,
                'query_category' => $query_category,
                'arr_category' => $arr_category
            ];

            return view('frontend.collections.detail_where_buy', $response);
        } else {
            return \Redirect::back();
        }
    }

    public function famous_brand()
    {
        $brands = $this->brand->getAll()->toArray();
        usort($brands, function ($a, $b) {
            if (count($a['items']) === count($b['items'])) return 0;
            return (count($a['items']) < count($b['items'])) ? 1 : -1;
        });

        $response = [
            'title' => trans("index.nhungthuonghieunoitieng"),
            'brands' => $brands
        ];
        return view('frontend.collections.famous_brand', $response);
    }

    public function detail_famous_brand($brand_id)
    {
        $brand = $this->brand->find($brand_id);

        if ($brand != null) {
            $product_type = category_item();
            $category_brand = $this->item->distinctCategory($brand_id);
            $raw_categories = $this->category->getAll(["category_type = $product_type"]);
            $categories = CategoryHelper::group_by_id($raw_categories);

            $query_category = '';
            $arr_category = [];

            if ($this->request->has('category')) {
                $query_category = $this->request->input('category');
                $arr_category = explode(',', $query_category);
            }

            $response = [
                'title' => trans("index.nhungthuonghieunoitieng"),
                'brand' => $brand,
                'category_brand' => $category_brand,
                'categories' => $categories,
                'query_category' => $query_category,
                'arr_category' => $arr_category
            ];

            return view('frontend.collections.detail_famous_brand', $response);
        } else {
            return \Redirect::back();
        }
    }

    public function featured_items()
    {
        $items = $this->item->getAll(["featured = 1"]);
        $category_item = $this->item->distinctFeatured();
        $product_type = category_item();
        $raw_categories = $this->category->getAll();
        $categories = CategoryHelper::group_by_id($raw_categories);

        $query_category = '';
        $arr_category = [];

        if ($this->request->has('category')) {
            $query_category = $this->request->input('category');
            $arr_category = explode(',', $query_category);
        }

        $response = [
            'title' => trans("index.sanphamdanghot"),
            'category_item' => $category_item,
            'categories' => $categories,
            'query_category' => $query_category,
            'arr_category' => $arr_category,
            'items' => $items
        ];

       // return view('frontend.collections.featured_items', $response);

        return view('v2.collections.featured_items', $response);
    }

    public function sale_items()
    {

        $items = $this->item->getAll(["is_sale = 1"]);
        $category_item = $this->item->distinctSale();
        $product_type = category_item();
        $raw_categories = $this->category->getAll();
        $categories = CategoryHelper::group_by_id($raw_categories);

        $query_category = '';
        $arr_category = [];

        if ($this->request->has('category')) {
            $query_category = $this->request->input('category');
            $arr_category = explode(',', $query_category);
        }

        $response = [
            'title' => trans("index.sanphamgiamgiamoingay"),
            'category_item' => $category_item,
            'categories' => $categories,
            'query_category' => $query_category,
            'arr_category' => $arr_category,
            'items' => $items
        ];

        //return view('frontend.collections.featured_items', $response);

        return view('v2.collections.featured_items', $response);
    }
}
