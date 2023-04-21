<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\ForgotPasswordMail;
use App\Repositories\Admin\Dashboard\AdminRepository;
use App\Repositories\Auth\PasswordResetRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class ForgotPasswordController extends Controller
{
    protected $adminRepository;

    protected $passwordResetRepository;

    public function __construct(AdminRepository $adminRepository, PasswordResetRepository $passwordResetRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->passwordResetRepository = $passwordResetRepository;
    }


    public function showFormForgotPassword()
    {
        $data = [
            'routePostForgotPassword' => route('admin.adminPostForgotPassword'),
            'routerLogin' => route('admin.adminLogin'),
        ];
        return view('common.auth.forgot-password',$data);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postForgotPassword(ForgotPasswordRequest $request)
    {
        $email = $request->get('email');
        $isAdmin = $this->adminRepository->checkIsEmailAdmin($email);
        if ($isAdmin->count() > 0) {
            $subject = trans('login.title_reset_password_admin');
            $userName = $isAdmin->first()->name;
            $token = Str::random(config('constant.random_token'));
            $data = array('email' => $email, 'token' => $token);
            DB::beginTransaction();
            try {
                $this->passwordResetRepository->createPasswordReset($data);
                $url = URL::temporarySignedRoute('admin.adminResetPassword', now()->addMinutes(config('constant.time_limit_link')), ['token' => $token]);
                Mail::to($email)->send(new ForgotPasswordMail($url, $subject, $userName));
                DB::commit();
                return redirect()->route('admin.adminLogin')->with('message', trans('login.success_forgot'));
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['message'=> trans('login.error_forgot')]);
            }
        }
        return redirect()->back()->withErrors(['message'=> trans('login.error_forgot')]);
    }
}
