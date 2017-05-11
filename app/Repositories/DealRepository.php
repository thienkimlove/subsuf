<?php
namespace App\Repositories;


use App\Deal;

class DealRepository
{
    protected $deal;

    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
    }

    function select($query = [])
    {
        $statement = $this->deal;
        foreach ($query as $key => $value) {
            $statement = $statement->where($key, $value);
        }

        return $statement->orderBy('created_at', 'desc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function insert($data)
    {
        $titleVi = $data['title_vi'];
        $titleEn = $data['title_en'];
        $descVi = $data['desc_vi'];
        $descEn = $data['desc_en'];

        unset($data['title_vi']);
        unset($data['title_en']);
        unset($data['desc_vi']);
        unset($data['desc_en']);



        $deal = $this->deal->create($data);

        $deal->translateOrNew('vi')->title = $titleVi;
        $deal->translateOrNew('en')->title = $titleEn;

        $deal->translateOrNew('vi')->desc = $descVi;
        $deal->translateOrNew('en')->desc = $descEn;

        $deal->save();
    }

    public function update($deal_id, $data)
    {
        $deal = Deal::find($deal_id);


        $deal->translateOrNew('vi')->title = $data['title_vi'];
        $deal->translateOrNew('en')->title = $data['title_en'];

        $deal->translateOrNew('vi')->desc = $data['desc_vi'];
        $deal->translateOrNew('en')->desc = $data['desc_en'];

        $deal->save();

        unset($data['title_vi']);
        unset($data['title_en']);
        unset($data['desc_vi']);
        unset($data['desc_en']);

        $this->deal->where('id', $deal_id)->update($data);
    }

    public function find($deal_id)
    {
        return $this->deal->find($deal_id);
    }

    public function delete($deal_id)
    {
        return $this->deal->destroy($deal_id);
    }

}