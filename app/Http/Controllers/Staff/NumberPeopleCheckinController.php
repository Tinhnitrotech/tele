<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Place\PlaceRepository;
use App\Repositories\Staff\Person\PersonRepository;
use App\Repositories\Staff\PeopleCheckin\PeopleCheckinRepository;
use Illuminate\Http\Request;

class NumberPeopleCheckinController extends Controller
{

    /**
     * @var $placeRepository
     */
    protected $placeRepository;

    /**
     * @var $personRepository
     */
    protected $personRepository;

    /**
     * @var $peopleCheckinRepository
     */
    protected $peopleCheckinRepository;

    /**
     * Staff DashBoardController Construct
     */
    public function __construct(PlaceRepository $placeRepository, PersonRepository $personRepository, PeopleCheckinRepository $peopleCheckinRepository)
    {
        $this->placeRepository = $placeRepository;
        $this->personRepository = $personRepository;
        $this->peopleCheckinRepository = $peopleCheckinRepository;
    }
    /**
     * @return
     */
    public function index()
    {
        $place = null;
        $personTotal = null;
        try {
            $placeId = getPlaceID();
            $place = $this->placeRepository->getDetailPlace($placeId);
            $detail = $this->peopleCheckinRepository->getDetailData();
            if (!empty($place->family)) {
                $personTotal = $this->personRepository->getTotalPersonOption($place->family);
            }
        } catch (\Exception $e) {
            report($e);
        }

        return view('staff.register_user_checkin', compact( 'personTotal', 'detail'));
    }

    /**
     * Post user checkin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function postPeopleCheckin(Request  $request) {
        $placeId = getPlaceID();
        $place = $this->placeRepository->getDetailPlace($placeId);
        $personTotalCheckin = $this->peopleCheckinRepository->getDetailData();
        if(is_null($personTotalCheckin)) {
            $personTotalCheckin = 0;
        } else {
            $personTotalCheckin = $personTotalCheckin->total_person_checkin;
        }

        $personTotalFamily = 0;
        $personInHospital = 0;
        $personTotalCheck = 0;
        if (!empty($place->family)) {
            $personTotalFamilyData = $this->personRepository->getTotalPersonOption($place->family);
            if($personTotalFamilyData) {
                $personInHospital = array_sum($personTotalFamilyData) - $personTotalFamilyData['person_total'] - $personTotalFamilyData['person_option_9'];
                $personTotalFamily = $personTotalFamilyData['person_total'];
            }
        }

        $params = $request->except('_token');
        $personTotal = filter_var($params['total_person_checkin'], FILTER_SANITIZE_NUMBER_INT);
        $personReq = filter_var($params['pregnant'], FILTER_SANITIZE_NUMBER_INT)
            + filter_var($params['infants'], FILTER_SANITIZE_NUMBER_INT)
            + filter_var($params['disability'], FILTER_SANITIZE_NUMBER_INT)
            + filter_var($params['caregiver'], FILTER_SANITIZE_NUMBER_INT)
            + filter_var($params['medical_device_user'], FILTER_SANITIZE_NUMBER_INT)
            + filter_var($params['allergic'], FILTER_SANITIZE_NUMBER_INT)
            + filter_var($params['foreign'], FILTER_SANITIZE_NUMBER_INT)
            + filter_var($params['other'], FILTER_SANITIZE_NUMBER_INT);
        if($personTotalCheckin == $personTotal){
            $personTotalCheck = $personTotalCheckin + $personTotalFamily;
        } else {
            $personTotalCheck = $personTotal + $personTotalFamily;
        }

        if($personReq > ($personTotalCheck - $personInHospital) || $personReq > $personTotalCheck){
            return redirect()->back()->with('error', trans('common.user_checkin_invalid'));
        } else {
            $result = $this->peopleCheckinRepository->createOrUpdatePeopleCheckin($params);
            if ($result) {
                return redirect()->back()->with('message', trans('common.create_success'));
            }
            return redirect()->back()->with('error', trans('common.create_failed'));
        }

    }

}
