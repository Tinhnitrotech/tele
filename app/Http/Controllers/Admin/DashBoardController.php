<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Repositories\Admin\Place\PlaceRepository;
use App\Repositories\Admin\SystemSetting\SystemSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Google\Cloud\Vision\VisionClient;
use Exception;

class DashBoardController extends Controller
{
    protected $placeRepository;

    protected $systemSettingRepository;

    public function __construct(PlaceRepository $placeRepository, SystemSettingRepository $systemSettingRepository)
    {
        $this->placeRepository = $placeRepository;
        $this->systemSettingRepository = $systemSettingRepository;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = $this->placeRepository->getListPlace();
        return view('admin.dashboard',compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.adminLogin');
    }

    /**
     * Setting system view
     *
     * @return
     */
    public function settingSystem() {
        $setting = $this->systemSettingRepository->getSetting();
        return view('admin.setting_system', compact('setting'));
    }

    /**
     * Setting system form post
     *
     * @param SettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettingSystem(SettingRequest $request)
    {
        try {
            if ($request->file('image_logo')) {
                if(File::exists(public_path('images/logo.png'))) {
                    File::delete(public_path('images/logo.png'));
                }
                $destinationPath = 'storage/images/';
                $profileImage = "logo.png";
                $request->file('image_logo')->move(public_path($destinationPath), $profileImage);
            }

            $data = $request->except(['_token', 'image_logo']);
            $result = $this->systemSettingRepository->saveSettingSystem($data);
            if($result) {
                return redirect()->route('admin.settingSystem')->with('message', trans('common.update_success'));
            }
            return redirect()->back()->withErrors(['message'=> trans('common.update_failed')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message'=> trans('common.update_failed')]);
        }


    }

    /**
     * Redirect page Dashboard
     *
     */
    public function goToDashboard()
    {
        return redirect()->route('admin.adminDashboard');
    }

}
