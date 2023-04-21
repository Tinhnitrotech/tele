<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Repositories\Admin\Dashboard\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    protected $adminRepository;


    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.change-password');
    }


    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ChangePasswordRequest $request)
    {
        $id = Auth::user()->id;
        $checkPassword = $this->adminRepository->checkPasswordCurrent($request, $id);
        if ($checkPassword) {
            $result = $this->adminRepository->resetPassword($request, $id);
            if ($result) {
                return redirect()->route('admin.adminDashboard')->with('message', trans('login.change_password_success'));
            }
            return redirect()->back()->with('message', trans('login.error_forgot'));
        }
        return redirect()->back()->with('message', trans('login.password_current_wrong'));
    }
}
