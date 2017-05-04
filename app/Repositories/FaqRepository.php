<?php
namespace App\Repositories;

use App\Faq;

class FaqRepository
{
    protected $faq;

    public function __construct(Faq $faq)
    {
        $this->faq = $faq;
    }

    public function select($query = [])
    {
        $statement = $this->faq->with('language_ref');
        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        return $statement->orderBy('language', 'asc')->orderBy('faq_order', 'asc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($faq_id)
    {
        return $this->faq->with('language_ref')->find($faq_id);
    }

    public function insert($data)
    {
        $this->faq->insert($data);
    }

    public function update($faq_id, $data)
    {
        $this->faq->where('faq_id', $faq_id)->update($data);
    }

    public function delete($faq_id)
    {
        return $this->faq->destroy($faq_id);
    }
}