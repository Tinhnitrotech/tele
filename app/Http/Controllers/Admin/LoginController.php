<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Admin\Dashboard\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    protected $adminRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(AdminRepository $adminRepository)
    {
        $this->middleware('guest:admin')->except('logout');
        $this->adminRepository = $adminRepository;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFormLogin()
    {
        $data = [
            'loginTitle' => trans('login.login_title_admin'),
            'routePostLogin' => route('admin.adminPostLogin'),
            'routeForgot' => route('admin.adminForgotPassword'),
            'routerSignUp' => ''
        ];
        return view('common.auth.login',$data);
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postFormLogin(LoginRequest $request)
    {
        $where = $request->except(['_token']);
        if (Auth::guard('admin')->attempt($where)) {
            $result = $this->adminRepository->checkFirstLoginByEmail($where['email']);
            if (!is_null($result)) {
                return redirect()->route('admin.adminDashboard');
            } else {
                $this->adminRepository->updateFirstLoginByEmail($where['email']);
                return redirect()->route('admin.adminChangePassword');
            }
        } else {
            return redirect()->route('admin.adminLogin')->withInput($request->input())->withErrors(['message' => 'ログインに失敗しました']);
        }
    }
}
