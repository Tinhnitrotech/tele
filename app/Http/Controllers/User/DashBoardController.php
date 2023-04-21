<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CheckoutRequest;
use App\Models\Place;
use App\Repositories\Admin\Place\PlaceRepository;
use App\Repositories\Staff\Family\FamilyRepository;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Google\Cloud\Vision\VisionClient;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DashBoardController extends Controller
{

    /**
     * @var userRepository
     */
    protected $userRepository;

    /**
     * @var placeRepository
     */
    public $placeRepository;

    /**
     * @var familyRepository
     */
    protected $familyRepository;

    public function __construct(UserRepository $userRepository, PlaceRepository $placeRepository, FamilyRepository $familyRepository)
    {
        $this->userRepository = $userRepository;
        $this->placeRepository = $placeRepository;
        $this->familyRepository = $familyRepository;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $hinan = request()->query('hinan');
        $isActive = false;
        if (!empty($hinan)) {
            Session::put('placeID', $hinan);
            $checkError500 = checkPlaceIdError500();
            if ($checkError500) {
                $isActive = false;
                Session::flash('error',trans('common.place_inactive_message'));
            } else {
                $isActive = true;
                Session::forget('error');
            }
        }
        return view('user.guest',compact('isActive'));
    }

    public function getListPlace() {
        $result = $this->placeRepository->getAllPlaceInfo();
        return view('user.list_place',compact('result'));
    }

    /** Get list Place on PIN MAP
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function map()
    {
        $placeRepo = new PlaceRepository();
        $placesResult = $placeRepo->getAllPlaceInfo();
        return view('user.map', compact('placesResult'));
    }

    /** Get list place
     *
     * @return
     */
    public function place(){
        $placeRepo = new PlaceRepository();
        $placesResult = $placeRepo->getAllPlaceInfo();
        return view('user.place', compact('placesResult'));
    }



    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function member()
    {
        $data = [
            [1, trans('staff_refuge_detail.representative'), trans('staff_refuge_detail.td_1_3'), 60, trans('common.male'), '', '', '2021/06/01'],
            [2, '', trans('staff_refuge_detail.td_2_3'), 58, trans('common.female'), '', '', '2021/06/01'],
            [3, '', trans('staff_refuge_detail.td_3_3'), 85, trans('common.female'), '', '', '2021/06/01'],
            [4, '', trans('staff_refuge_detail.td_4_3'), 87, trans('common.male'), '', '', '2021/06/01'],
        ];
        return view('user.member', compact('data'));

    }

    public function register()
    {
        $userAgent = checkUserAgent();
        $data = $this->familyRepository->getDataAttribute();
        $routeAction = routeByPlaceId('user.confirm');
        $registerUser = session('registerUser');
        if ($registerUser) {
            $data = $registerUser;
            session()->forget('registerUser');
        }
        return view('user.register', compact('data', 'routeAction', 'userAgent'));
    }

    public function registerConfirm(Request $request)
    {
        if (!empty($request->has('person'))) {
            $data = $request->except(['person', '_token']);
            $person = $request->get('person');
            $public_info = $request->get('public_info');
			$data['person'] = $person;
			isset($public_info) ? $public_info = 1 : $public_info = 0;
            $data['public_info'] = $public_info;
	        Session::put('registerUser',$data);
            $dataPerson = array_filter($person, function ($value) {
                return $value['name'] != null;
            });
            if (!empty($dataPerson)) {
                $data['person'] = $dataPerson;
                return view('user.register_confirm', compact('data'));
            } else {
                return redirect()->route('user.register');
            }
        }

        if (!empty(session('errors')) && !empty(session('errors')->has('errors_beyond_capacity'))) {
            $getRegisterUser = Session::get('registerUser');
            $getRegisterUser['errors_beyond_capacity'] = session('errors')->first('errors_beyond_capacity');
            Session::put('registerUser', $getRegisterUser);
        }

        return redirectRouteByPlaceId('user.register');
    }

    public function registerSuccess()
    {
        $this->familyRepository->saveQRCode(session('familyId'));
        $data = $this->familyRepository->getFamilyById(session('familyId'));
        return view('user.register_success', compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detectQrCode(Request $request)
    {
        $data = $request->except(['_token']);
        $dataQr = decryptData($data['content']);
        $results = json_decode($dataQr);

        $html = [];
        foreach ($results as $key => $result) {
            $number = $key+1;
            if($result[6] == 'M') {
                $gender = 1;
            } else {
                $gender = 2;
            }

            $now = Carbon::now()->format('Y-m-d');

            $endDate = new \DateTime($now);
            $startDate = new \DateTime($result[5]);
            $age = $endDate->diff($startDate)->y;

            $person = [
                'name' => $result[0],
                'is_owner' => 0,
                'age' => $age,
                'gender' => $gender,
           ];

            $userInfo = [
                'postal_code_1' => $result[1],
                'postal_code_2' => $result[2],
                'address' => handleAddressCSV($result[3]),
                'tel' => handleTelQRCode($result[4]),
                'age' => $age,
                'gender' => $gender,
            ];


            $html[] = view('staff.refuge.person_item', compact('person', 'number'))->render();
        }

        $response = [
            'code' => config('constants.SUCCESS'),
            'html_form' => $html,
            'user_info' => $userInfo,
        ];
        return response()->json($response);

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function annotateImage()
    {
        return view('demo');
    }

    /**
     * @param Request $request
     * @return false|\Illuminate\Http\JsonResponse
     */
    public function detectImageDemo(Request $request)
    {
        try {

            $data = $request->except(['_token']);
            $fileUpload = $data['file']; // image base64 encoded data

            $uploadDir = 'public/images/capture/';
            $pathStorage = 'storage/images/capture/';
            $path = null;

            // Clear old data on system
            $file = new Filesystem();
            $file->cleanDirectory($pathStorage);

            $extension = $fileUpload->getClientOriginalExtension();
            $imageName = time() . '.' .$extension;
            if (Storage::disk('local')->put($uploadDir . $imageName, file_get_contents($fileUpload))) {
                $path = $pathStorage . $imageName;
            } else {
                return false;
            }

            $vision = new VisionClient(['keyFile' => json_decode(file_get_contents(__DIR__ . '/keyfile.json'), true)]);
            $imageRes = fopen($path, 'r');
            $imageScan = $vision->image($imageRes, ['TEXT_DETECTION']);

            $annotation = $vision->annotate($imageScan);
            $document = $annotation->fullText();
            $text = empty($document) ? null : $document->text();
            $data = explode(PHP_EOL, $text);
            $response = [
                'data' => isset($text) ? $data : null,
            ];

            return response()->json($response);



//            $data = $request->except(['_token']);
//            $image_64 = $data['content']; // image base64 encoded data
//            $uploadDir = 'public/images/capture/';
//            $pathStorage = 'storage/images/capture/';
//            $path = null;
//
//            // Cover base64 to image
//            $extension = explode('/', explode(':', substr($image_64, 1, strpos($image_64, ';')))[1])[1];
//            $extension = str_replace(';', '', $extension);
//            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
//            $image = str_replace($replace, '', $image_64);
//            $image = str_replace(' ', '+', $image);;
//            $imageName = Str::random(10) . strtotime(\Carbon\Carbon::now()) . '.' . $extension;
//            $imageOptimize = Image::make(base64_decode($image))->stream($extension, 100);
//
//            // Clear old data on system
//            $file = new Filesystem();
//            $file->cleanDirectory($pathStorage);
//
//            if (Storage::disk('local')->put($uploadDir . $imageName, $imageOptimize)) {
//                $path = $pathStorage . $imageName;
//            } else {
//                return false;
//            }
//
//            $vision = new VisionClient(['keyFile' => json_decode(file_get_contents(__DIR__ . '/keyfile.json'), true)]);
//            $imageRes = fopen($path, 'r');
//            $imageScan = $vision->image($imageRes, ['TEXT_DETECTION']);
//
//            $annotation = $vision->annotate($imageScan);
//            $document = $annotation->fullText();
//            $text = empty($document) ? null : $document->text();
//            $data = explode(PHP_EOL, $text);
//            $response = [
//                'data' => isset($text) ? $data : null,
//            ];

//            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json(['result' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return false|\Illuminate\Http\JsonResponse
     */
    public function detectImage(Request $request)
    {
        try {
            $data = $request->except(['_token']);
            $image_64 = $data['content']; // image base64 encoded data

            $uploadDir = 'public/images/capture/';
            $pathStorage = 'storage/images/capture/';
            $path = null;

            // Cover base64 to image
            $extension = explode('/', explode(':', substr($image_64, 1, strpos($image_64, ';')))[1])[1];
            $extension = str_replace(';', '', $extension);
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);;
            $imageName = Str::random(10) . strtotime(\Carbon\Carbon::now()) . '.' . $extension;
            $imageOptimize = Image::make(base64_decode($image))->stream($extension, 100);

            // Clear old data on system
            $file = new Filesystem();
            $file->cleanDirectory($pathStorage);

            if (Storage::disk('local')->put($uploadDir . $imageName, $imageOptimize)) {
                $path = $pathStorage . $imageName;
            } else {
                return false;
            }

            $vision = new VisionClient(['keyFile' => json_decode(file_get_contents(__DIR__ . '/keyfile.json'), true)]);
            $imageRes = fopen($path, 'r');
            $imageScan = $vision->image($imageRes, ['TEXT_DETECTION']);

            $annotation = $vision->annotate($imageScan);
            $document = $annotation->fullText();
            $text = empty($document) ? '' : $document->text();
            $data = explode(PHP_EOL, $text);
            $address = isset($data[2]) ? preg_replace('/住所/u', '', $data[2]) : '';
            $number = 1;
            $person = [
                'name' => isset($data[1]) ? $data[1] : '',
                'is_owner' => 0
            ];
            $html = view('staff.refuge.person_item', compact('person', 'number'))->render();
            $userInfo = [
                'address' => $address
            ];
            $response = [
                'code' => config('constants.SUCCESS'),
                'html_form' => $html,
                'user_info' => $userInfo,
            ];
        return response()->json($response);

        } catch (\Exception $e) {
            return response()->json(['result' => $e->getMessage()]);
        }
    }

    public function checkOut()
    {
        return view('user.checkout');
    }

    /**
     * Ajax search family
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSearchFamily(CheckoutRequest $request)
    {
        $data = $request->except(['_token']);
        $result = $this->userRepository->ajaxSearchFamily($data);
        return response()->json(['result' => $result]);
    }

    public function leave($familyId) {
        $family = $this->userRepository->updateFamilyLeave($familyId);
        if($family) {
            return redirectRouteByPlaceId('userCheckout', [], trans('user_register.checkout_success'));
        } else {
            return redirect()->back()->with('message', trans('user_register.checkout_fail'));
        }
    }

    /**
     * CheckIn Family Remote
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkInRemote(Request  $request) {
        $data = $request->except(['_token']);
        $family = $this->userRepository->checkInRemoteFamily($data);
        if($family == config('constant.check_in_again')) {
            return redirectRouteByPlaceId('user.member', [], trans('user_register.checkin_again'));
        } elseif($family == config('constant.check_in')) {
            return redirectRouteByPlaceId('user.member', [], trans('user_register.checkin_success'));
        } else {
            return redirect()->back()->with('error', trans('user_register.checkin_fail'));
        }
    }
}
