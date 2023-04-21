<?php

namespace App\Http\Controllers\Staff;

use App\Exports\FamilyExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\AddFamilyRequest;
use App\Repositories\Admin\Place\PlaceRepository;
use App\Repositories\Staff\Family\FamilyRepository;
use App\Repositories\Staff\Person\PersonRepository;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class RefugeController extends Controller
{
    use SoftDeletes;

    /**
     * @var familyRepository
     */
    protected $familyRepository;

    /**
     * @var personRepository
     */
    protected $personRepository;

    /**
     * @var placeRepository
     */
    protected $placeRepository;

    /**
     * @var userRepository
     */
    protected $userRepository;

    /**
     * RefugeController constructor.
     *
     * @param familyRepository        $familyRepository
     * @param personRepository        $personRepository
     * @param placeRepository         $placeRepository
     */
    public function __construct(FamilyRepository $familyRepository, PersonRepository $personRepository, PlaceRepository $placeRepository,UserRepository $userRepository)
    {
        $this->familyRepository = $familyRepository;
        $this->personRepository = $personRepository;
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Show list refuge
     *
     * @param $request Illuminate\Http\Request
     */
    public function index(Request $request)
    {
        $placeId = $request->place_id ?? getPlaceID();
        $data = $this->personRepository->getPersonByFamily($placeId,$request);
        $total_family = $this->personRepository->countTotalFamily($request);
        $data->family_code = $request->family_code ?? '';
        $data->name = $request->name ?? '';
        return view('staff.refuge.index', compact('data', 'total_family'));
    }

    /**
     * Show Form Add Family
     */
    public function addFamily()
    {
        $userAgent = checkUserAgent();
        $data = $this->familyRepository->getDataAttribute();
        $sectionTitle = trans('staff_add_family.section_title');
        $routeAction = route('staff.confirmFamily');
        $staffRegisterUser = session('staffRegisterUser');
        if ($staffRegisterUser) {
            $data = $staffRegisterUser;
            session()->forget('staffRegisterUser');
        }
        return view('staff.refuge.family', compact('data', 'sectionTitle', 'routeAction', 'userAgent'));
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
            Session::put('staffRegisterUser',$data);
            $dataPerson = array_filter($person, function ($value) {
                return $value['name'] != null;
            });
            if (!empty($dataPerson)) {
                $data['person'] = $dataPerson;
                return view('staff.refuge.register_confirm', compact('data'));
            } else {
                return redirect()->route('staff.familyIndex');
            }
        }

        if (!empty(session('errors')) && !empty(session('errors')->has('errors_beyond_capacity'))) {
            $staffRegisterUser = Session::get('staffRegisterUser');
            $staffRegisterUser['errors_beyond_capacity'] = session('errors')->first('errors_beyond_capacity');
            Session::put('staffRegisterUser', $staffRegisterUser);
        }

        return redirectRouteByPlaceId('staff.familyIndex');
    }

    /**
     * @param $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAddFamilyAndPerson(AddFamilyRequest $request)
    {
        $isExists = $this->familyRepository->checkPersonIsExistsInFamily($request->person, $request->tel);
        if ($isExists) {
            $registerUser = session('registerUser');
            $staffRegisterUser = session('staffRegisterUser');
            if (!empty($request->user_register_family) && $request->user_register_family == 1 && $registerUser) {
                return redirectRouteByPlaceId('user.register', [], trans('common.error_exists_person'));
            }

            if (!empty($request->user_register_family) && $request->user_register_family == 1 && $staffRegisterUser) {
                return redirectRouteByPlaceId('staff.addFamily', [], trans('common.error_exists_person'));
            }
        }

        $result = $this->familyRepository->createAddFamilyAndPerson($request);
        if ($result) {
            $registerUser = session('registerUser');
            $staffRegisterUser = session('staffRegisterUser');
            if ($registerUser) {
                session()->forget('registerUser');
            }
            if ($staffRegisterUser) {
                session()->forget('staffRegisterUser');
            }

            if (!empty($request->user_register_family) && $request->user_register_family == 1 && $registerUser) {
                return redirect()->route('user.success', ['hinan' => getPlaceID()])->with([
                    'message', trans('common.ms_update_family'),
                    'familyCode' => $result['family_code'],
                    'familyId' => $result['family_id']
                ]);
            }

            if (!empty($request->user_register_family) && $request->user_register_family == 1 && $staffRegisterUser) {
                return redirectRouteByPlaceId('staff.familyIndex', [], trans('common.ms_update_family'));
            }

            return redirectRouteByPlaceId('staff.familyIndex', [], trans('common.ms_create_add_family'));
        } else {
            return redirect()->back()->with('error', trans('common.er_create'));
        }
    }

    /**
     * Show Detail
     *
     * @param int $id
     */
    public function detail($id,Request $request)
    {
        $data = $this->familyRepository->getFamilyById($id);
//        if(!$data['qr_code']) {
//            $this->familyRepository->saveQRCode($id);
//            $data = $this->familyRepository->getDetailFamily($id);
//        }
        $data->perfecture_name = $data->language_register == config('constant.language_ja') ? get_prefecture_name($data->prefecture_id) : get_prefecture_name_en($data->prefecture_id);
        $history = $this->familyRepository->getHistoryCheckInByFamilyId($id,$request);
        return view('staff.refuge.detail', compact('data','id','history'));
    }

    /**
     * Edit Detail
     *
     * @param int $id
     */
    public function editFamily($id)
    {
        $data = $this->familyRepository->getDataAttribute($id);
        $sectionTitle = trans('staff_add_family.section_title_edit');
        $routeAction = route('staff.postEditFamily', ['id' => $id]);
        return view('staff.refuge.family', compact('data', 'sectionTitle', 'routeAction'));
    }

    /**
     * @param $id
     * @param $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editFamilyAndPerson(AddFamilyRequest $request, $id)
    {
        $isExists = $this->familyRepository->checkEditPersonIsExistsInFamily($request);
        if ($isExists) {
            return redirect()->back()->with('error', trans('common.error_exists_person'));
        }

        $result = $this->familyRepository->editAddFamilyAndPerson($request, $id);
        if ($result) {
            return redirectRouteByPlaceId('staff.familyIndex', [], trans('common.ms_update_family'));
        } else {
            return redirect()->back()->with('error', trans('common.er_create'));
        }
    }

    public function checkout($id)
    {
        $family = $this->userRepository->updateFamilyLeave($id);
        if($family) {
            return redirectRouteByPlaceId('staff.familyIndex', [], trans('user_register.checkout_success'));
        } else {
            return redirect()->back()->with('message', trans('user_register.checkout_fail'));
        }
    }

    public function exportCSV(Request $request)
    {
        $date = Carbon::now();
        $formatDateTime = $date->format('YmdHis');
        $name = 'StaffFamily_'.$formatDateTime.'.csv';
        return Excel::download(new FamilyExport($request), $name);
    }
}
