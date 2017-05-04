<?php
namespace App\Repositories;

use App\Brand;

class BrandRepository
{
    protected $brand;

    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    function select($query = [])
    {
        $statement = $this->brand;

        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        $statement = $statement->with('items');

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

    public function find($brand_id)
    {
        return $this->brand->find($brand_id);
    }

    public function insert($data)
    {
        $this->brand->insert($data);
    }

    public function update($brand_id, $data)
    {
        $this->brand->where('brand_id', $brand_id)->update($data);
    }

    public function delete($brand_id)
    {
        return $this->brand->destroy($brand_id);
    }
}