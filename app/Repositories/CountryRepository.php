<?php
namespace App\Repositories;

use App\Country;

class CountryRepository
{
    protected $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    function select($country = '')
    {
        return $this->country->orderBy('country_code', 'asc')
            ->where("name", "like", "%$country%");
    }

    public function getAll($country = '')
    {
        return $this->select($country)->get();
    }

    public function getLimit($limit, $country = '')
    {
        return $this->select($country)->paginate($limit);
    }

    public function find($country_id)
    {
        return $this->country->find($country_id);
    }

    public function insert($data)
    {
        $this->country->insert($data);
    }

    public function update($country_id, $data)
    {
        $this->country->where('country_id', $country_id)->update($data);
    }

    public function delete($country_id)
    {
        return $this->country->destroy($country_id);
    }
}