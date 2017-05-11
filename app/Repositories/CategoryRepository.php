<?php
namespace App\Repositories;

use App\Category;

class CategoryRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    function select($query = [])
    {
        $statement = $this->category;

        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        return $statement->orderBy('is_showed', 'desc')
            ->orderBy('category_order', 'asc')
            ->orderBy('name', 'asc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->with('translations')->paginate($limit);
    }

    public function find($category_id)
    {
        return $this->category->with(['websites' => function ($query) {
            $query->orderBy('website_order', 'asc');
        }])->find($category_id);
    }

    public function insert($data)
    {

        $nameVi = $data['name_vi'];
        $nameEn = $data['name_en'];
        unset($data['name_vi']);
        unset($data['name_en']);


        $category = $this->category->create($data);

        $category->translateOrNew('vi')->name = $nameVi;
        $category->save();
        $category->translateOrNew('en')->name = $nameEn;
        $category->save();

    }

    public function update($category_id, $data)
    {
        $category = Category::find($category_id);
        $category->translateOrNew('vi')->name = $data['name_vi'];
        $category->save();
        $category->translateOrNew('en')->name = $data['name_en'];
        $category->save();
        unset($data['name_vi']);
        unset($data['name_en']);
        $this->category->where('category_id', $category_id)->update($data);


    }

    public function delete($category_id)
    {
        return $this->category->destroy($category_id);
    }

    public function getWithWebsites()
    {
        return $this->category->orderBy("category_order", "asc")
            ->with('websites')->where('category_type', category_website())->get();
    }
}