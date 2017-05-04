<?php
namespace App\Repositories;


use App\Exchange;

class ExchangeRepository
{
    protected $exchange;

    public function __construct(Exchange $exchange)
    {
        $this->exchange = $exchange;
    }

    function select($query = [])
    {
        $statement = $this->exchange;
        foreach ($query as $key => $value) {
            $statement = $statement->where($key, $value);
        }

        return $statement->orderBy('money', 'desc');
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
        $this->exchange->insert($data);
    }

    public function update($exchange_id, $data)
    {
        $this->exchange->where('exchange_id', $exchange_id)->update($data);
    }

    public function find($exchange_id)
    {
        return $this->exchange->find($exchange_id);
    }

    public function delete($exchange_id)
    {
        return $this->exchange->destroy($exchange_id);
    }

    public function change($from, $to)
    {
        $exchange = $this->exchange->where("from_currency", $from)->where("to_currency", $to)->first();
        if ($exchange) {
            return (float)$exchange->money;
        }
        return 0;
    }
}