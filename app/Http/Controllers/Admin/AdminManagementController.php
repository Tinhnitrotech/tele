<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditAdminRequest;
use App\Http\Requests\Admin\RegisterAdminRequest;
use App\Repositories\Admin\Dashboard\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AdminManagementExport;
use App\Exports\AdminManagementImport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;


class AdminManagementController extends Controller
{
    public $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Get list admin
     *
     * @param Request $request
     * @return
     */
    public function index(Request $request)
    {
        $listAdmin = $this->adminRepository->getlistAdmin($request);
        return view('admin.admin.index',compact('listAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        return view('admin.admin.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegisterAdminRequest $request)
    {
        $result = $this->adminRepository->addAdmin($request);
        $message = $result ? trans('common.create_success') : trans('common.create_failed');
        if ($result) {
            return redirect()->route('admin.adminManagement')->with('success', $message);
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
        $detail = $this->adminRepository->getDetailAdmin($id);
        return view('admin.admin.detail',compact('detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return
     */
    public function edit($id)
    {
        $detail = $this->adminRepository->getDetailAdmin($id);
        return view('admin.admin.form',compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EditAdminRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->adminRepository->updateAdmin($request, $id);
            DB::commit();
            return redirect()->route('admin.adminManagement')->with('success', trans('common.update_success'));
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
            $this->adminRepository->destroy($id);
            DB::commit();
            return redirect()->route('admin.adminManagement')->with('success', trans('common.delete_success'));
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
        $name = 'AdminManagement_' . $formatDateTime . '.csv';
        return Excel::download(new AdminManagementExport(), $name);
    }

    /**
     * @return
     */
    public function importCSVView()
    {
        return view('admin.admin.import_csv');
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
            Excel::import(new AdminManagementImport(), request()->file('csv_file'));
            DB::commit();
            return redirect()->route('admin.adminManagement')->with('success', trans('admin_management.import_csv_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', trans('admin_management.import_csv_fail'));
        }
    }

}
