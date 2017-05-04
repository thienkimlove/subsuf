<?php
namespace App\Repositories;

use App\Notification;

class NotificationRepository
{
    protected $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    function select($query = [])
    {
        $statement = $this->notification
            ->with('from_user')
            ->with('to_user')
            ->with('order');

        foreach ($query as $key => $value) {
            $statement = $statement->where($key, $value);
        }

        return $statement->orderBy('sent_at', 'desc');
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
        return $this->notification->insertGetId($data);
    }

    public function find($notification_id)
    {
        return $this->notification
            ->with('from_user')
            ->with('to_user')
            ->with('order')
            ->where('notification_id', $notification_id)->first();
    }
}