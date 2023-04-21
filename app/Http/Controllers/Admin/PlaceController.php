<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PlaceExport;
use App\Exports\PlaceImport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlaceRequest;
use App\Repositories\Admin\Place\PlaceRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PlaceController extends Controller
{
    protected $placeRepository;

    public function __construct(PlaceRepository $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }


    public function getRefugeList()
    {
        $result = $this->placeRepository->getListPlaceAdmin();
        return view('admin.places.place_list', compact('result'));
    }

    public function edit($id)
    {
        $detail = $this->placeRepository->getDetailPlace($id);
        $zip_code = explode('-', $detail->zip_code);
        $zip_code_default = explode('-', $detail->zip_code_default);
        $detail->postal_code_1 = $zip_code[0];
        $detail->postal_code_2 = $zip_code[1];
        $detail->postal_code_default_1 = $zip_code_default[0];
        $detail->postal_code_default_2 = $zip_code_default[1];
        return view('admin.places.place_create',compact('detail'));
    }

    public function create()
    {
        $detail = [];
        return view('admin.places.place_create', compact('detail'));
    }

    /**
     * /Crete Place
     *
     * @param PlaceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PlaceRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            $place = $this->placeRepository->createPlace($data);
            if($place) {
                $this->placeRepository->createMapPlace($data, $place->id);
                DB::commit();
                return redirect()->route('admin.adminPlaceList')->with('message', trans('common.create_success'));
            }
            return redirect()->back()->withErrors(['message'=> trans('common.create_failed')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message'=> trans('common.create_failed')]);
        }
    }

    public function update(PlaceRequest $request, $id)
    {
        $data = $request->except(['_token']);
        $active_flag = isset($data['active_flag']) ? 0 : 1;
        $check = $this->placeRepository->checkActivePlace($id, $active_flag);
        if($check) {
           return redirect()->back()->withErrors(['message'=> trans('common.update_failed')]);
        }
        $place = $this->placeRepository->editPlace($data, $id);
        if($place) {
            return redirect()->route('admin.adminDetail', ['id' => $id])->with('message', trans('common.update_success'));
        }
        return redirect()->back()->withErrors(['message'=> trans('common.update_failed')]);

    }

    /**
     * Get detail Place
     *
     * @param $id
     */
    public function show($id)
    {
        $detail = $this->placeRepository->getDetailPlace($id);
        $placesResult = $this->placeRepository->getPlaceDetailInfo($id);
        return view('admin.places.place_detail',compact('detail', 'placesResult'));
    }

    /**
     * Change full member status
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeFullStatus($id) {
        $status = $this->placeRepository->changeFullStatus($id);
        if($status) {
            return redirect()->route('admin.adminDashboard')->with('message', trans('common.update_success'));
        }
        return redirect()->back()->withErrors(['message'=> trans('common.update_failed')]);
    }

    /**
     * Change status active place
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeActiveStatus($id) {
        $status = $this->placeRepository->changeActiveStatus($id);
        if($status) {
            return redirect()->route('admin.adminPlaceList')->with('message', trans('common.update_success'));
        }
        return redirect()->back()->withErrors(['message'=> trans('common.update_failed')]);
    }

    /**
     * Delete Place
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id,Request $request)
    {
        $check = $this->placeRepository->checkActivePlace($id, 0);
        if($check) {
            return redirect()->back()->withErrors(['message'=> trans('common.delete_failed')]);
        }
        $place = $this->placeRepository->deletePlace($id);
        if($place) {
            return redirect()->route('admin.adminPlaceList', ['id' => $id])->with('message', trans('common.delete_success'));
        }
        return redirect()->back()->withErrors(['message'=> trans('common.delete_failed')]);

    }

    /**
     * @return
     */
    public function importCSVView()
    {
        return view('admin.places.import_csv');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCSV()
    {
        $date = Carbon::now();
        $formatDateTime = $date->format('YmdHis');
        $name = 'Place_'.$formatDateTime.'.csv';
        return Excel::download(new PlaceExport(), $name);
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
            Excel::import(new PlaceImport(),request()->file('csv_file'));
            DB::commit();
            return redirect()->route('admin.adminPlaceList')->with('message', trans('place.import_csv_success'));
        } catch (\InvalidArgumentException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', trans('place.import_csv_fail'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', trans('place.import_data_fail'));
        } catch (\Error $e) {
            DB::rollBack();
            return redirect()->back()->with('error', trans('place.import_csv_fail'));
        }

    }
}
