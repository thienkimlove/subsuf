<?php
namespace App\Repositories;


use App\Account;

class AccountRepository
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    function select($query = [])
    {
        $statement = $this->account;
//        $statement->with('account');
        foreach ($query as $key => $value) {
            if ($key == 'account_status' || $key == 'is_verified' || $key == 'from_account_id') {
                $statement = $statement->where($key, $value);
            } elseif ($key == 'full_name') {
                $statement = $statement->whereRaw("CONCAT_WS(' ', first_name, last_name) LIKE '%$value%' OR CONCAT_WS(' ', last_name, first_name) LIKE '%$value%'");
            } else {
                $statement = $statement->where($key, 'like', "%$value%");
            }
        }

        return $statement->orderBy('email', 'asc');
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
        $this->account->insert($data);
    }

    public function update($account_id, $data)
    {
        $this->account->where('account_id', $account_id)->update($data);
    }

    public function find($account_id)
    {
        return $this->account->with('account')->find($account_id);
    }

    public function findWithPayment($account_id)
    {
        return $this->account
            ->with('payment_cards')
            ->with('paypals')
            ->find($account_id);
    }

    public function findWithOrders($account_id, $start = '', $end = '')
    {
        return $this->account->with(['orders' => function ($query) use ($start, $end) {
            if ($start != '') {
                $query->where('request_time', '>=', "$start");
            }

            if ($end != '') {
                $query->where('request_time', '<=', "$end 23:59:59");
            }

            $query->orderBy('request_time', 'desc');
        }])->find($account_id);
    }

    public function delete($account_id)
    {
        return $this->account->destroy($account_id);
    }
}