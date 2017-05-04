<?php
namespace App\Repositories;

use App\Blog;

class BlogRepository
{
    protected $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    function select($query = [])
    {
        $statement = $this->blog;

        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        return $statement->orderBy('time_created', 'desc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($blog_id)
    {
        return $this->blog->find($blog_id);
    }

    public function findBySlug($slug)
    {
        return $this->blog->where('slug', $slug)
            ->where('is_published', 1)->first();
    }

    public function insert($data)
    {
        $this->blog->insert($data);
    }

    public function update($blog_id, $data)
    {
        $this->blog->where('blog_id', $blog_id)->update($data);
    }

    public function delete($blog_id)
    {
        return $this->blog->destroy($blog_id);
    }
}