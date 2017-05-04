<?php
namespace App\Repositories;

use App\Location;

class LocationRepository
{
    protected $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    function select($query = [])
    {
        $statement = $this->location;
        if (!empty($query)) {
            foreach ($query as $key => $value) {
                if ($key == 'name') {
                    $statement = $statement->where($key, 'like', "%$value%");
                } else {
                    $statement = $statement->where($key, $value);
                }
            }
        }

        return $statement->orderBy('is_showed', 'desc')
            ->orderBy('location_order', 'asc')
            ->orderBy('name', 'asc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($location_id)
    {
        return $this->location->with(['websites' => function ($query) {
            $query->orderBy('website_order', 'asc');
        }])->find($location_id);
    }

    public function insert($data)
    {
        $this->location->insert($data);
    }

    public function update($location_id, $data)
    {
        $this->location->where('location_id', $location_id)->update($data);
    }

    public function delete($location_id)
    {
        return $this->location->destroy($location_id);
    }

    public function getWithWebsites()
    {
        return $this->location->with('websites')->where('type', get_nation())->get();
    }
}