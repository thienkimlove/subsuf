<?php

namespace App\Http\Controllers\Admin;

use App\Helper\EncryptHelper;
use App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;
use Redirect;
use Validator;

class AccessController extends Controller
{
    private $request;
    private $adminRepository;

    public function __construct(Request $request, AdminRepository $adminRepository)
    {
        $this->request = $request;
        $this->adminRepository = $adminRepository;
    }

    public function redirect()
    {
        if (!$this->request->session()->has('admin')) {
            return Redirect::action('Admin\AccessController@login');
        }

        return Redirect::action('Admin\AdminDasboardController@index');
    }

    public function login()
    {
        $response = [
            'title' => 'Trang quản trị',
            'description' => ''
        ];

        if ($this->request->isMethod('post')) {
            $validator = Validator::make($this->request->all(), [
                'username' => "required|alpha_dash",
                'password' => "required|min:6|max:32"
            ], [
                'username.required' => "Tên đăng nhập không được để trống",
                'username.alpha_dash' => "Tên đăng nhập chứa ký tự đặc biệt",
                'password.required' => "Mật khẩu không được để trống",
                'password.min' => "Mật khẩu từ 6 đến 32 ký tự",
                'password.max' => "Mật khẩu từ 6 đến 32 ký tự",
            ]);

            if ($validator->fails()) {
                $response['status'] = "error";
                $response['message'] = $validator->errors()->first();
            } else {
                $username = trim($this->request->input('username'));
                $password = trim($this->request->input('password'));

                $admin = $this->adminRepository->findByUser($username, EncryptHelper::password($password));
                if ($admin != null) {
//                    echo json_encode($admin);die;
                    $this->request->session()->put('admin', $admin);
                    $this->request->session()->put('authorities', $admin->role->permissions);

                    return Redirect::action('Admin\AdminDasboardController@index');
                } else {
                    $response['status'] = "error";
                    $response['message'] = "Tên đăng nhập hoặc mật khẩu không đúng";
                }
            }
        }

        return view('admin.access.login', $response);
    }

    public function logout()
    {
        if ($this->request->session()->has('admin')) {
            $this->request->session()->forget('admin');
        }

        $this->request->session()->flush();
        return Redirect::action('Admin\AccessController@login');
    }

    public function denied()
    {
        return view('admin.access.access_denied', ["title" => "Không có quyền truy cập", "description" => ""]);
    }
}
