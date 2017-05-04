<?php
namespace App\Repositories;

use App\Offer;

class OfferRepository
{
    protected $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    function select($query = [])
    {
        $statement = $this->offer;

        foreach ($query as $key => $value) {
            $statement = $statement->whereRaw($value);
        }

        $statement = $statement->with('account')->with('from_location');

        return $statement->get();
    }

    public function getAll($query = [])
    {
        return $this->select($query)->get();
    }

    public function getLimit($limit, $query = [])
    {
        return $this->select($query)->paginate($limit);
    }

    public function find($offer_id)
    {
        return $this->offer->with('account')
            ->with('from_location')
            ->with('order')
            ->find($offer_id);
    }

    public function findByOrder($order_id)
    {
        return $this->offer->with('account')
            ->with('from_location')
            ->where('order_id', $order_id)
            ->orderBy('offer_time', 'desc')
            ->get();
    }
}