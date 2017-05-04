<?php
namespace App\Repositories;

use App\Coupon;

class CouponRepository
{
    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    function select($query = [])
    {
        $statement = $this->coupon->with('account');

        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        return $statement->orderBy('status', 'desc')
            ->orderBy('used_at', 'desc')
            ->orderBy('money', 'desc');
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($coupon_id)
    {
        return $this->coupon->find($coupon_id);
    }

    public function insert($data)
    {
        $this->coupon->insert($data);
    }

    public function update($coupon_id, $data)
    {
        $this->coupon->where('coupon_id', $coupon_id)->update($data);
    }

    public function delete($coupon_id)
    {
        return $this->coupon->destroy($coupon_id);
    }
}