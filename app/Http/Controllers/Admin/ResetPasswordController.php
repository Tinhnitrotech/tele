<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Repositories\Admin\Dashboard\AdminRepository;
use App\Repositories\Auth\PasswordResetRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    protected $passwordResetRepository;

    protected $adminRepository;

    public function __construct(PasswordResetRepository $passwordResetRepository, AdminRepository $adminRepository)
    {
        $this->passwordResetRepository = $passwordResetRepository;
        $this->adminRepository = $adminRepository;
    }

    public function showFormResetPassword()
    {
        $data = [
            'routePostResetPassword' => route('admin.adminPostResetPassword'),
            'routerLogin' => route('admin.adminLogin')
        ];
        return view('common.auth.recover-password',$data);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function postResetPassword(ResetPasswordRequest $request)
    {
        $token = $request->get('token');
        $data['password'] = Hash::make($request->get('password'));
        DB::beginTransaction();
        try {
            $email = $this->passwordResetRepository->getEmailByToken($token);
            $this->adminRepository->updateAdminByEmail($email, $data);
            $this->passwordResetRepository->deleteEmailByEmail($email);
            DB::commit();
            return redirect()->route('admin.adminLogin')->with('message', trans('login.change_password_success'));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message'=> trans('login.error_forgot')]);
        }
    }
}
