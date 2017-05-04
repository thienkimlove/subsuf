<?php
namespace App\Repositories;

use App\Website;

class WebsiteRepository
{
    protected $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    function select($query = [])
    {
        $statement = $this->website;

        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        $statement = $statement->with('nation')->with('category');

        return $statement->orderBy('is_showed', 'desc')
            ->orderBy('website_order', 'asc')
            ->orderBy('name', 'asc');;
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($website_id)
    {
        return $this->website->find($website_id);
    }

    public function insert($data)
    {
        $this->website->insert($data);
    }

    public function update($website_id, $data)
    {
        $this->website->where('website_id', $website_id)->update($data);
    }

    public function delete($website_id)
    {
        return $this->website->destroy($website_id);
    }

    public function distinctCategory($location_id = 0)
    {
        $statement = $this->website->select('category_id')->groupBy('category_id');

        if ($location_id != 0) {
            $statement = $statement->where('location_id', $location_id);
        }

        return $statement->get();
    }
}