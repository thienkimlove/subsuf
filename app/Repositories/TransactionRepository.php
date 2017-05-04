<?php
namespace App\Repositories;

use App\Transaction;

class TransactionRepository
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    function select($query = [])
    {
        $statement = $this->transaction;

        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        $statement = $statement->with('offer');

        return $statement->orderBy('transaction_date', 'desc')->orderBy('transaction_status', 'desc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($transaction_id)
    {
        return $this->transaction->with('coupon')->with('offer')
            ->find($transaction_id);
    }

    public function getSuccessByAccount($account_id, $start = '', $end = '')
    {
        $statement = $this->transaction->whereHas('offer', function ($query) use ($account_id) {
            $query->where('traveler_id', $account_id)->orderBy('offer_time', 'desc');
        });

        if ($start != '') {
            $statement = $statement->where('transaction_date', '>=', "$start");
        }

        if ($end != '') {
            $statement = $statement->where('transaction_date', '<=', "$end");
        }

        return $statement->with('offer')->whereIn('transaction_status', [2, 3])->orderBy('transaction_date', 'desc')->get();
    }
}