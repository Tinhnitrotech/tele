<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MasterSupplyExport;
use App\Exports\MasterSupplyImport;
use App\Exports\SupplyExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\MasterMaterial\AddMasterMaterialRequest;
use App\Repositories\Admin\Place\PlaceRepository;
use App\Repositories\MasterMaterial\Dashboard\MasterMaterialRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
{
    public $masterMaterialRepository;
    public $placeRepository;

    public function __construct(MasterMaterialRepository $masterMaterialRepository,PlaceRepository $placeRepository)
    {
        $this->masterMaterialRepository = $masterMaterialRepository;
        $this->placeRepository = $placeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $listMasterMaterial = $this->masterMaterialRepository->getListMaterial();
        return view('admin.material.material_list',compact('listMasterMaterial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() {
        return view('admin.material.material_create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail = $this->masterMaterialRepository->getDetail($id);
        return view('admin.material.material_create',compact('detail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddMasterMaterialRequest $request)
    {
        $result = $this->masterMaterialRepository->addMasterMaterial($request);
        $message =  $result ? trans('common.create_success') : trans('common.create_failed');
        if ($result) {
            return redirect()->route('admin.adminMaterialList')->with('success', $message);
        } else {
            return redirect()->back()->with('error', $message);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AddMasterMaterialRequest $request,$id)
    {
        DB::beginTransaction();
        try {
            $this->masterMaterialRepository->updateMaterial($request, $id);
            DB::commit();
            return redirect()->route('admin.adminMaterialList')->with('success', trans('common.update_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', trans('common.update_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id,Request $request)
    {
        DB::beginTransaction();
        try {
            $this->masterMaterialRepository->destroy($id);
            DB::commit();
            return redirect()->route('admin.adminMaterialList')->with('success', trans('common.delete_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error',trans('common.delete_failed'));
        }
    }

    public function getShortageSupplyList()
    {
        $listMasterMaterial = $this->masterMaterialRepository->getMasterMaterial();
        $listShortageSuppliesByPlace = array();
        if (!$listMasterMaterial->isEmpty()){
            $listShortageSuppliesByPlace = $this->placeRepository->getShortageSuppliesByPlace($listMasterMaterial);
        }
        return view('admin.material.shortage_supplies',compact('listMasterMaterial','listShortageSuppliesByPlace'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCSV()
    {
        $date = Carbon::now();
        $formatDateTime = $date->format('YmdHis');
        $name = 'Shortage-supplies_'.$formatDateTime.'.csv';
        return Excel::download(new SupplyExport(), $name);
    }

    public  function exportCSVMasterSupply()
    {
        $date = Carbon::now();
        $formatDateTime = $date->format('YmdHis');
        $name = 'MasterMaterial'.$formatDateTime.'.csv';
        return Excel::download(new MasterSupplyExport(), $name);
    }

    /**
     * @return
     */
    public function importCSVView()
    {
        return view('admin.material.import_csv');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importCSV(Request $request)
    {
        $file = request()->file('csv_file');
        if(!$request->file('csv_file')) {
            return redirect()->back()->with('message_validate', trans('common.required_csv_input'));
        }
        if ($file->getClientOriginalExtension() != 'csv') {
            return redirect()->back()->with('message_validate', trans('common.cvs_valid'));
        }
        DB::beginTransaction();
        try {
            Excel::import(new MasterSupplyImport(),request()->file('csv_file'));
            DB::commit();
            return redirect()->route('admin.adminMaterialList')->with('success', trans('material.import_csv_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', trans('material.import_csv_fail'));
        }

    }
}
