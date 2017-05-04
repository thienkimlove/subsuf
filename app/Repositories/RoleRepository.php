<?php
namespace App\Repositories;

use App\Role;

class RoleRepository
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function getAll()
    {
        return $this->role->orderBy('name', 'asc')->get();
    }

    public function find($role_id)
    {
        return $this->role->with('permissions')->find($role_id);
    }

    public function insert($data)
    {
        return $this->role->insertGetId($data);
    }

    public function update($role_id, $data)
    {
        $this->role->where('role_id', $role_id)->update($data);
    }

    public function delete($role_id)
    {
        return $this->role->destroy($role_id);
    }
}