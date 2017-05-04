<?php
namespace App\Repositories;

use App\BlogCategory;

class BlogCategoryRepository
{
    protected $blogCategory;

    public function __construct(BlogCategory $blogCategory)
    {
        $this->blogCategory = $blogCategory;
    }

    function select($query = [])
    {
        $statement = $this->blogCategory;

        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        return $statement->orderBy('name', 'asc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($category_id)
    {
        return $this->blogCategory->find($category_id);
    }

    public function findBySlug($slug)
    {
        return $this->blogCategory->where('slug', $slug)
            ->where('status', 1)->first();
    }

    public function insert($data)
    {
        $this->blogCategory->insert($data);
    }

    public function update($category_id, $data)
    {
        $this->blogCategory->where('category_id', $category_id)->update($data);
    }

    public function delete($category_id)
    {
        return $this->blogCategory->destroy($category_id);
    }

    public function getWithBlog()
    {
        return $this->blogCategory->with('blog')->get();
    }
}