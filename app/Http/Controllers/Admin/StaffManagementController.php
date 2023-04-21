<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterStaffRequest;
use App\Repositories\Staff\Dashboard\StaffRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\StaffManagementExport;
use App\Exports\StaffManagementImport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class StaffManagementController extends Controller
{
    public $staffRepository;

    public function __construct(StaffRepository $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listStaff = $this->staffRepository->getlistStaff($request);
        return view('admin.staff.index',compact('listStaff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.staff.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegisterStaffRequest $request)
    {
        $result = $this->staffRepository->addStaff($request);
        $message = $result ? trans('common.create_success') : trans('common.create_failed');
        if ($result) {
            return redirect()->route('admin.staffManagement')->with('success', $message);
        } else {
            return back()->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = $this->staffRepository->getDetailStaff($id);
        return view('admin.staff.detail',compact('detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail = $this->staffRepository->getDetailStaff($id);
        return view('admin.staff.form',compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RegisterStaffRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->staffRepository->updateStaff($request, $id);
            DB::commit();
            return redirect()->route('admin.staffManagement')->with('success', trans('common.update_success'));
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
            $this->staffRepository->destroy($id);
            DB::commit();
            return redirect()->route('admin.staffManagement')->with('success', trans('common.delete_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', trans('common.delete_failed'));
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCSV()
    {
        $date = Carbon::now();
        $formatDateTime = $date->format('YmdHis');
        $name = 'StaffManagement_' . $formatDateTime . '.csv';
        return Excel::download(new StaffManagementExport(), $name);
    }

    /**
     * @return
     */
    public function importCSVView()
    {
        return view('admin.staff.import_csv');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importCSV(Request $request)
    {
        $file = request()->file('csv_file');
        if (!$request->file('csv_file')) {
            return redirect()->back()->with('message_validate', trans('common.required_csv_input'));
        }
        if ($file->getClientOriginalExtension() != 'csv') {
            return redirect()->back()->with('message_validate', trans('common.cvs_valid'));
        }
        DB::beginTransaction();
        try {
            Excel::import(new StaffManagementImport(), request()->file('csv_file'));
            DB::commit();
            return redirect()->route('admin.staffManagement')->with('success', trans('staff_management.import_csv_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', trans('staff_management.import_csv_fail'));
        }
    }

}
