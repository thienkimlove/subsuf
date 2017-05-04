<?php
namespace App\Repositories;

use App\Item;

class ItemRepository
{
    protected $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    function select($query = [])
    {
        $statement = $this->item;

        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        $statement = $statement->with('category')->with('brand');

        return $statement->orderBy('is_showed', 'desc')
            ->orderBy('item_order', 'asc')
            ->orderBy('price', 'desc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($item_id)
    {
        return $this->item->find($item_id);
    }

    public function insert($data)
    {
        $this->item->insert($data);
    }

    public function update($item_id, $data)
    {
        $this->item->where('item_id', $item_id)->update($data);
    }

    public function delete($item_id)
    {
        return $this->item->destroy($item_id);
    }

    public function distinctCategory($brand_id = -1)
    {
        $statement = $this->item->select('category_id')->groupBy('category_id');

        if ($brand_id != -1) {
            $statement = $statement->where('brand_id', $brand_id);
        }

        return $statement->get();
    }

    public function distinctFeatured()
    {
        $statement = $this->item->select('category_id')->groupBy('category_id')->where('featured', 1);

        return $statement->get();
    }

    public function distinctSale()
    {
        $statement = $this->item->select('category_id')->groupBy('category_id')->where('is_sale', 1);

        return $statement->get();
    }
}