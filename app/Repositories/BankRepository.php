<?php
namespace App\Repositories;


use App\Bank;

class BankRepository
{
    protected $bank;

    public function __construct(Bank $bank)
    {
        $this->bank = $bank;
    }

    function select($query = [])
    {
        $statement = $this->bank->with('country');
        if (!empty($query)) {
            foreach ($query as $key => $value) {
                if ($key == 'name') {
                    $statement->where($key, 'like', "%$value%");
                } else {
                    $statement->where($key, $value);
                }
            }
        }

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

    public function insert($data)
    {
        $this->bank->insert($data);
    }

    public function update($bank_id, $data)
    {
        $this->bank->where('bank_id', $bank_id)->update($data);
    }

    public function find($bank_id)
    {
        return $this->bank->with('country')->find($bank_id);
    }

    public function delete($bank_id)
    {
        return $this->bank->destroy($bank_id);
    }
}