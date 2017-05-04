<?php

namespace App\Http\Controllers\Admin;

use App\Helper\EncryptHelper;
use App\Helper\StatusHelper;
use App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $request;
    private $adminRepository;
    private $roleRepository;

    public function __construct(Request $request, AdminRepository $adminRepository, RoleRepository $roleRepository)
    {
        $this->request = $request;
        $this->title = 'Tài khoản admin';
        $this->adminRepository = $adminRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $accounts = $this->adminRepository->getAll();

        $response = [
            'title' => $this->title,
            'accounts' => $accounts,
            'account_status' => StatusHelper::account_admin(),
        ];

        return view('admin.account_admin.index', $response);
    }

    public function insert()
    {
        $roles = $this->roleRepository->getAll();

        $response = [
            'title' => $this->title,
            'roles' => $roles
        ];

        if ($this->request->isMethod('post')) {
            $validator = account_admin_validator($this->request);
            if (is_error($validator)) {
                return_error($validator, $response);
                return \Redirect::back()->withError($response['message']);
            } else {
                try {
                    $data = get_admin_form($this->request);
                    $this->adminRepository->insert($data);

                    return \Redirect::action('Admin\AdminController@index')
                        ->withSuccess('Thêm tài khoản mới thành công');
                } catch (\Exception $exception) {
                    return \Redirect::back()->withError(message_internal_error());
                }
            }
        }

        return view('admin.account_admin.insert', $response);
    }

    public function info($id)
    {
        $account = $this->adminRepository->find($id);
        if ($account !== null) {
            $response = [
                'title' => $this->title,
                'account' => $account,
                'account_status' => StatusHelper::account_admin(),
            ];

            return view('admin.account_admin.info', $response);
        } else {
            return \Redirect::back()->withError('Tài khoản không tồn tại');
        }
    }

    public function update($id)
    {
        $account = $this->adminRepository->find($id);
        if ($account != null) {
            $roles = $this->roleRepository->getAll();

            $response = [
                'title' => $this->title,
                'account' => $account,
                'roles' => $roles
            ];

            if ($this->request->isMethod('post')) {
                $validator = account_admin_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_admin_form($this->request, $account);
                        $this->adminRepository->update($id, $data);

                        return \Redirect::action('Admin\AdminController@info', $account->admin_id)
                            ->withSuccess('Cập nhật thông tin tài khoản thành công');
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.account_admin.update', $response);
        } else {
            return \Redirect::back()->withError('Tài khoản không tồn tại');
        }
    }

    public function ban($id)
    {
        try {
            $data = ['status' => -1];
            $this->adminRepository->update($id, $data);

            return \Redirect::back()->withSuccess('Đã tạm dừng tài khoản');
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }

    public function active($id)
    {
        try {
            $data = ['status' => 1];
            $this->adminRepository->update($id, $data);

            return \Redirect::back()->withSuccess('Đã kích hoạt tài khoản');
        } catch (\Exception $e) {
            return \Redirect::back()->withError(message_internal_error());
        }
    }

    public function change_password()
    {
        $admin = get_admin_session();
        if ($admin != null) {
            $response = [
                'title' => 'Đổi mật khẩu',
                'admin' => $admin
            ];

            if ($this->request->isMethod('post')) {
                $validator = change_password_validator($this->request);
                if (is_error($validator)) {
                    return_error($validator, $response);
                    return \Redirect::back()->withError($response['message']);
                } else {
                    try {
                        $data = get_change_password_form($this->request);

                        $old_password = EncryptHelper::password($data['old_password']);

                        if ($admin->password != $old_password) {
                            return \Redirect::back()->withError("Mật khẩu cũ không đúng");
                        }

                        $this->adminRepository->update($admin->admin_id, ['password' => EncryptHelper::password($data['password'])]);

                        return \Redirect::action('Admin\AdminDasboardController@index')->withSuccess('Đổi mật khẩu thành công');
                    } catch (\Exception $exception) {
                        return \Redirect::back()->withError(message_internal_error());
                    }
                }
            }

            return view('admin.account_admin.change_password', $response);
        } else {
            return \Redirect::action('Admin\AccessController@redirect');
        }
    }
}
