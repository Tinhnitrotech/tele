<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\SuppliesRequest;
use App\Repositories\MasterMaterial\Dashboard\MasterMaterialRepository;
use App\Repositories\Staff\Supply\SupplyRepository;

class SuppliesController extends Controller
{
    /**
     * @var $supplyRepository
     */
    protected $supplyRepository;

    /**
     * @var $masterMaterialRepository
     */
    protected $masterMaterialRepository;

    /**
     * Staff SuppliesController Construct
     */
    public function __construct(SupplyRepository $supplyRepository, MasterMaterialRepository $masterMaterialRepository) {
        $this->supplyRepository = $supplyRepository;
        $this->masterMaterialRepository = $masterMaterialRepository;
    }
    /**
     * Show Supplies
     */
    public function index()
    {
        $placeId = getPlaceID();
        $listMasterMaterial = $this->masterMaterialRepository->getListMaterial($placeId);
        $data = $this->supplyRepository->getSupplyByPlaceIdWithMaster($placeId, $listMasterMaterial);
        $listMasterMaterial = $this->supplyRepository->setValueListMasterMaterial($listMasterMaterial, $data['supplies']);
        return view('staff.supplies.index', compact('listMasterMaterial', 'placeId', 'data'));
    }

    /**
     * Store And Update Supplies
     *
     * @param  App\Http\Requests\Staff\SuppliesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAndUpdate(SuppliesRequest $request)
    {
        $data = $this->supplyRepository->getSupplyByPlaceId($request->place_id);

        if ($data['supplies']->isNotEmpty()) {
            /** Update */
            $store = $this->supplyRepository->updateSupplyByPlaceID($request, $request->place_id, $data['supplies']);
            $message = trans('common.ms_update_supply');
        } else {
            /** Create */
            $store = $this->supplyRepository->createSupplyAndNotes($request);
            $message = trans('common.ms_create_supply');
        }

        if ($store) {
            return redirectRouteByPlaceId('staff.suppliesIndex', [], $message);
        }
        return redirect()->back()->with('error', trans('common.er_create'));
    }
}
