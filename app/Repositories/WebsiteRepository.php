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

        $titleVi = $data['name_vi'];
        $titleEn = $data['name_en'];
        $descVi = $data['description_vi'];
        $descEn = $data['description_en'];

        unset($data['name_vi']);
        unset($data['name_en']);
        unset($data['description_vi']);
        unset($data['description_en']);



        $content = $this->website->create($data);

        $content->translateOrNew('vi')->name = $titleVi;
        $content->translateOrNew('en')->name = $titleEn;

        $content->translateOrNew('vi')->description = $descVi;
        $content->translateOrNew('en')->description = $descEn;

        $content->save();
    }

    public function update($website_id, $data)
    {

        $content = Website::find($website_id);


        $content->translateOrNew('vi')->name = $data['name_vi'];
        $content->translateOrNew('en')->name = $data['name_en'];

        $content->translateOrNew('vi')->description = $data['description_vi'];
        $content->translateOrNew('en')->description = $data['description_en'];

        $content->save();

        unset($data['name_vi']);
        unset($data['name_en']);
        unset($data['description_vi']);
        unset($data['description_en']);

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