<?php

namespace App\Http\Controllers\Admin;

use App\Helper\PermissionHelper;
use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $request;
    private $roleRepository;
    private $permissionRepository;

    public function __construct(Request $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->request = $request;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->title = 'Phân quyền';
    }

    public function index()
    {
        $roles = $this->roleRepository->getAll();

        $response = [
            'title' => $this->title,
            'roles' => $roles
        ];

        return view('admin.role.index', $response);
    }

    public function insert()
    {
        $modules = $this->permissionRepository->getModules();
        $functions = $this->permissionRepository->getFunctions();
        $permissions = PermissionHelper::permissions($modules, $functions);

        $response = [
            'title' => $this->title,
            'permissions' => $permissions
        ];

        if ($this->request->isMethod('post')) {
            $validator = role_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_role_form($this->request);
                    $role_id = $this->roleRepository->insert($data);
                    $role = $this->roleRepository->find($role_id);

                    if ($role != null) {
                        foreach ($modules as $module) {
                            if ($this->request->has('cb-md-' . $module->module_slug)) {
                                $role->permissions()->attach($module->permission_id,
                                    ['is_read' => 1, 'is_inserted' => 1, 'is_updated' => 1, 'is_deleted' => 1]);
                            }
                        }

                        foreach ($functions as $function) {
                            if ($this->request->has('cb-fn-' . $function->function_slug)) {
                                $permission_id = $function->permission_id;
                                $read = 0;
                                $inserted = 0;
                                $updated = 0;
                                $deleted = 0;

                                if ($this->request->has('cb-fn-' . $function->function_slug . '-read')) {
                                    $read = 1;
                                }
                                if ($this->request->has('cb-fn-' . $function->function_slug . '-insert')) {
                                    $inserted = 1;
                                }
                                if ($this->request->has('cb-fn-' . $function->function_slug . '-update')) {
                                    $updated = 1;
                                }
                                if ($this->request->has('cb-fn-' . $function->function_slug . '-delete')) {
                                    $deleted = 1;
                                }

                                $role->permissions()->attach($permission_id,
                                    ['is_read' => $read, 'is_inserted' => $inserted, 'is_updated' => $updated, 'is_deleted' => $deleted]);
                            }
                        }
                    }

                    return \Redirect::action('Admin\RoleController@index')->withSuccess(message_insert());
                } catch (\Exception $exception) {
                    $this->roleRepository->delete($role_id);
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        return view('admin.role.insert', $response);
    }

    public function info($id)
    {
        $role = $this->roleRepository->find($id);
        if ($role != null) {
            $response = [
                'title' => $this->title,
                'role' => $role
            ];

            return view('admin.role.info', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function update($id)
    {
        $role = $this->roleRepository->find($id);
        if ($role != null) {
            $modules = $this->permissionRepository->getModules();
            $functions = $this->permissionRepository->getFunctions();
            $permissions = PermissionHelper::permissions($modules, $functions);

            $response = [
                'title' => $this->title,
                'role' => $role,
                'permissions' => $permissions
            ];

            if ($this->request->isMethod('post')) {
                $validator = role_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_role_form($this->request);
                        $this->roleRepository->update($id, $data);

                        $new_permission = [];

                        foreach ($modules as $module) {
                            if ($this->request->has('cb-md-' . $module->module_slug)) {
                                $new_permission[$module->permission_id] =
                                    ['is_read' => 1, 'is_inserted' => 1, 'is_updated' => 1, 'is_deleted' => 1];
                            }
                        }

                        foreach ($functions as $function) {
                            if ($this->request->has('cb-fn-' . $function->function_slug)) {
                                $permission_id = $function->permission_id;
                                $read = 0;
                                $inserted = 0;
                                $updated = 0;
                                $deleted = 0;

                                if ($this->request->has('cb-fn-' . $function->function_slug . '-read')) {
                                    $read = 1;
                                }
                                if ($this->request->has('cb-fn-' . $function->function_slug . '-insert')) {
                                    $inserted = 1;
                                }
                                if ($this->request->has('cb-fn-' . $function->function_slug . '-update')) {
                                    $updated = 1;
                                }
                                if ($this->request->has('cb-fn-' . $function->function_slug . '-delete')) {
                                    $deleted = 1;
                                }

                                $new_permission[$permission_id] =
                                    ['is_read' => $read, 'is_inserted' => $inserted, 'is_updated' => $updated, 'is_deleted' => $deleted];
                            }
                        }

                        $role->permissions()->sync($new_permission);

                        return \Redirect::action('Admin\RoleController@index', $role->role_id)->withSuccess(message_update());
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.role.update', $response);
        } else {
            return \Redirect::back()->withError(message_not_found());
        }
    }

    public function delete($id)
    {
        try {
            if ($this->roleRepository->delete($id)) {
                return \Redirect::action('Admin\RoleController@index');
            }
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }
}
