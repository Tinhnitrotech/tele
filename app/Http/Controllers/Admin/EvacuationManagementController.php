<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FamilyExport;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Place\PlaceRepository;
use App\Repositories\Staff\Family\FamilyRepository;
use App\Repositories\Staff\Person\PersonRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EvacuationManagementController extends Controller
{
    public $placeRepository;
    public $familyRepository;
    public $personRepository;

    public function __construct(PlaceRepository $placeRepository,
                                FamilyRepository $familyRepository,
                                PersonRepository $personRepository)
    {
        $this->placeRepository = $placeRepository;
        $this->familyRepository = $familyRepository;
        $this->personRepository = $personRepository;
    }

    public function index(Request $request)
    {
        $places = $this->placeRepository->get();
        $placeId = $request->place_id ?? null;
        $data = $this->personRepository->getPersonByFamily($placeId,$request);
        $total_family = $this->personRepository->countTotalFamily($request,true);
        $data->family_code = $request->family_code ?? '';
        $data->name = $request->name ?? '';
        $data->place_id = $request->place_id ?? '';
        return view('admin.evacuation.index',compact('places','data','total_family'));
    }

    public function detailByHousehold($id,Request $request)
    {
        $data = $this->familyRepository->getDetailFamily($id);
//        if(!$data['qr_code']) {
//            $this->familyRepository->saveQRCode($id);
//            $data = $this->familyRepository->getDetailFamily($id);
//        }
        $history = $this->familyRepository->getHistoryCheckInByFamilyId($id,$request);
        return view('admin.evacuation.refuge_detail',compact('data','history'));
    }


    public function exportCSV(Request $request)
    {
        $date = Carbon::now();
        $formatDateTime = $date->format('YmdHis');
        $name = 'Evacuation_'.$formatDateTime.'.csv';
        return Excel::download(new FamilyExport($request), $name);
    }
}
