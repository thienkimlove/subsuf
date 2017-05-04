<?php
namespace App\Repositories;

use App\Permission;

class PermissionRepository
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getAll()
    {
        return $this->permission->orderBy('name', 'asc')->get();
    }

    public function getModules()
    {
        return $this->permission->where('function_slug', '')->orderBy('name', 'asc')->get();
    }

    public function getFunctions()
    {
        return $this->permission->where('function_slug', '!=', '')->orderBy('name', 'asc')->get();
    }

    public function find($permission_id)
    {
        return $this->permission->find($permission_id);
    }

    public function insert($data)
    {
        $this->permission->insert($data);
    }

    public function update($permission_id, $data)
    {
        $this->permission->where('permission_id', $permission_id)->update($data);
    }

    public function delete($permission_id)
    {
        return $this->permission->destroy($permission_id);
    }
}