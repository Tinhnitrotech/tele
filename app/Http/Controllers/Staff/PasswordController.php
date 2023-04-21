<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\ForgotPasswordMail;
use App\Repositories\Auth\PasswordResetRepository;
use App\Repositories\Staff\Dashboard\StaffRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    protected $staffRepository;

    protected $passwordResetRepository;

    /**
     * PasswordController constructor.
     * @param StaffRepository $userRepository
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(StaffRepository $staffRepository, PasswordResetRepository $passwordResetRepository)
    {
        $this->staffRepository = $staffRepository;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    /**
     * Show Form Forget Pass
     */
    public function showFormForgot()
    {
        $data = [
            'routePostForgotPassword' => route('staff.postStaffForgotPassword'),
            'routerLogin' => routeByPlaceId('staff.staffLogin'),
            'staffForgot' => true
        ];
        return view('common.auth.forgot-password', $data);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postFormForgot(ForgotPasswordRequest $request)
    {
        $email = $request->get('email');
        $isAdmin = $this->staffRepository->checkIsStaffEmail($email);
        if ($isAdmin->count() > 0) {
            $subject = trans('login.title_reset_password_staff');
            $userName = $isAdmin->first()->name;
            $token = Str::random(config('constant.random_token'));
            $data = array('email' => $email, 'token' => $token);
            DB::beginTransaction();
            try {
                $this->passwordResetRepository->createPasswordReset($data);
                $url = URL::temporarySignedRoute('staff.staffResetPassword', now()->addMinutes(config('constant.time_limit_link')), ['token' => $token, 'hinan' => getPlaceID()]);
                Mail::to($email)->send(new ForgotPasswordMail($url, $subject, $userName));
                DB::commit();
                return redirectRouteByPlaceId('staff.staffLogin', [], trans('login.success_forgot'));
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->withErrors(['message'=> trans('login.error_forgot')]);
            }
        }
        return redirect()->back()->withErrors(['message'=> trans('login.error_forgot')]);

    }

    /**
     * Show Form Reset Pass
     */
    public function showFormReset()
    {
        $data = [
            'routePostResetPassword' => route('staff.postStaffResetPassword'),
            'routerLogin' => routeByPlaceId('staff.staffLogin'),
            'staffReset' => true
        ];
        return view('common.auth.recover-password', $data);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postshowFormReset(ResetPasswordRequest $request)
    {
        $token = $request->get('token');
        $data['password'] = Hash::make($request->get('password'));
        DB::beginTransaction();
        try {
            $email = $this->passwordResetRepository->getEmailByToken($token);
            $this->staffRepository->updateStaffByEmail($email, $data);
            $this->passwordResetRepository->deleteEmailByEmail($email);
            DB::commit();
            return redirectRouteByPlaceId('staff.staffLogin', [], trans('login.change_password_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message'=> trans('login.error_forgot')]);
        }
    }
}
