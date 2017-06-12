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
        return $this->select($query)->orderBy('item_id', 'desc')->paginate($limit);
    }

    public function find($item_id)
    {
        return $this->item->find($item_id);
    }

    public function insert($data)
    {

        $titleVi = $data['name_vi'];
        $titleEn = $data['name_en'];
        $descVi = $data['description_vi'];
        $descEn = $data['description_en'];

        unset($data['name_vi']);
        unset($data['name_en']);
        unset($data['description_vi']);
        unset($data['description_en']);



        $content = $this->item->create($data);

        $content->translateOrNew('vi')->name = $titleVi;
        $content->translateOrNew('en')->name = $titleEn;

        $content->translateOrNew('vi')->description = $descVi;
        $content->translateOrNew('en')->description = $descEn;

        $content->save();
    }

    public function update($item_id, $data)
    {

        $content = Item::find($item_id);


        $content->translateOrNew('vi')->name = $data['name_vi'];
        $content->translateOrNew('en')->name = $data['name_en'];

        $content->translateOrNew('vi')->description = $data['description_vi'];
        $content->translateOrNew('en')->description = $data['description_en'];

        $content->save();

        unset($data['name_vi']);
        unset($data['name_en']);
        unset($data['description_vi']);
        unset($data['description_en']);

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