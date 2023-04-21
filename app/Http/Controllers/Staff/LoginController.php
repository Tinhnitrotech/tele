<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Staff\Dashboard\StaffRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $staffRepository;

    /**
     * Var
     */
    protected $redirectTo = '/staff/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StaffRepository $staffRepository)
    {
        $this->staffRepository = $staffRepository;
        $this->middleware('guest:staff')->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard()
    {
        return Auth::guard('staff');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showFormLogin()
    {
        $data = [
            'loginTitle' => trans('login.login_title_staff'),
            'routePostLogin' => route('staff.postStaffLogin'),
            'routeForgot' => routeByPlaceId('staff.staffForgotPassword'),
            'routerSignUp' => routeByPlaceId('staff.postStaffRegister'),
            'staffLogin' => true
        ];
        return view('common.auth.login', $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postFormLogin(LoginRequest $request)
    {
        $where = $request->except(['_token']);
        if (Auth::guard('staff')->attempt($where)) {
            $result = $this->staffRepository->checkFirstLoginByEmail($where['email']);
            if(!is_null($result)) {
                return redirectRouteByPlaceId('staff.staffDashboard');
            } else {
                $this->staffRepository->updateFirstLogin($where['email']);
                return redirectRouteByPlaceId('staff.staffChangePassword');
            }
        } else {
            return redirect()->route('staff.staffLogin', ['hinan' => getPlaceID()])->withInput($request->input())->withErrors(['message' => trans('login.error')]);
        }
    }
}
