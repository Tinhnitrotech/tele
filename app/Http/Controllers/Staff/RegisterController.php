<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Show Form Register
     */
    public function showFormRegister()
    {
        $data = [
            'routePostRegister' => routeByPlaceId('staff.postStaffRegister'),
            'routerLogin' => routeByPlaceId('staff.staffLogin')
        ];
        return view('common.auth.register', $data);
    }
}
