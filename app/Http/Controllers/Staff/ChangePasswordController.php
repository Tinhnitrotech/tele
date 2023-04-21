<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Repositories\Staff\Dashboard\StaffRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    protected $staffRepository;

    public function __construct(StaffRepository $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('staff.change-password');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ChangePasswordRequest $request)
    {
        $id = Auth::user()->id;
        $checkPassword = $this->staffRepository->checkPasswordCurrent($request, $id);
        if ($checkPassword) {
            $result = $this->staffRepository->resetPassword($request, $id);
            if ($result) {
                return redirectRouteByPlaceId('staff.staffDashboard', [], trans('login.change_password_success'));
            }
            return redirect()->back()->with('message', trans('login.error_forgot'));
        }
        return redirect()->back()->with('message', trans('login.password_current_wrong'));
    }
}
