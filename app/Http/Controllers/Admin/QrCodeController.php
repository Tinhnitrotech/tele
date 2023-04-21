<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SampleCSVExport;
use App\Http\Controllers\Controller;
use App\Jobs\CsvToQrProcess;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use File;
use ZipArchive;

class QrCodeController extends Controller
{

    /**
     * @return
     */
    public function importCSVView()
    {
        $batch = null;
        if(Session::has('batch_id')) {
            $batch = Bus::findBatch(Session::get('batch_id'));
            return view('admin.qrcode.download_zip', compact('batch'));
        }
        return view('admin.qrcode.import_csv', compact('batch'));
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

        try {
            $csv    = file($request->csv_file);
            unset($csv[0]); // remove header

            $csvRecord = count($csv);

            if ($csvRecord < 1) {
                return redirect()->back()->with('error', trans('qrcode.import_csv_fail'));
            } elseif ($csvRecord < 1000) {
                $chunks = array_chunk($csv,10);
            } elseif ($csvRecord < 20000) {
                $chunks = array_chunk($csv,20);
            } else {
                $chunks = array_chunk($csv,50);
            }

            $userId = Auth::id();
            $pathQrCreate = storage_path('app/public/images/qrcreate/' . $userId);
            if(!File::isDirectory($pathQrCreate)){
                File::makeDirectory($pathQrCreate, 0777, true, true);
            }
            $pathQrZip = storage_path('app/public/images/qrzip/' . $userId);
            if(!File::isDirectory($pathQrZip)){
                File::makeDirectory($pathQrZip, 0777, true, true);
            }
            File::cleanDirectory(storage_path('app/public/images/qrcreate/' . $userId));

            $batch  = Bus::batch([])->dispatch();

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);

                $batch->add(new CsvToQrProcess($data, $userId));
            }

            Session::put('batch_id', $batch->id);

            return redirect()->back()->with('message', trans('qrcode.import_csv_success'));
        } catch (\InvalidArgumentException $e) {
            report($e);
            return redirect()->back()->with('error', trans('qrcode.import_csv_fail'));
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', trans('qrcode.import_csv_fail'));
        } catch (\Error $e) {
            report($e);
            return redirect()->back()->with('error', trans('qrcode.import_csv_fail'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadZip()
    {
        $userId = Auth::id();
        $pathQrCreate = storage_path('app/public/images/qrcreate/' . $userId);
        if(!File::isDirectory($pathQrCreate)){
            File::makeDirectory($pathQrCreate, 0777, true, true);
        }

        $files = File::files(storage_path('app/public/images/qrcreate/' . $userId));
        if (count($files) == 0) {
            Session::forget('batch_id');
            return redirect()->back()->with('error', trans('qrcode.no_qrcode_download'));
        }

        $zip = new ZipArchive;
        $fileName = 'app/public/images/qrzip/' . $userId . '/QrCodes' . time() . '.zip';

        $pathQrZip = storage_path('app/public/images/qrzip/' . $userId);
        if(!File::isDirectory($pathQrZip)){
            File::makeDirectory($pathQrZip, 0777, true, true);
        }

        File::cleanDirectory(storage_path('app/public/images/qrzip/' . $userId));

        try {
            if ($zip->open(storage_path($fileName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE)
            {
                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    $zip->addFile($value, $relativeNameInZipFile);
                }
                 
                $zip->close();
            }
        } catch (\InvalidArgumentException $e) {
            report($e);
            return redirect()->back()->with('error', trans('qrcode.download_qrcode_fail'));
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', trans('qrcode.download_qrcode_fail'));
        } catch (\Error $e) {
            report($e);
            return redirect()->back()->with('error', trans('qrcode.download_qrcode_fail'));
        }
    
        return response()->download(storage_path($fileName));
    }

    /**
     * @return
     */
    public function cancelZip()
    {
        if(Session::has('batch_id')) {
            $batch = Bus::findBatch(Session::get('batch_id'));
            if (!empty($batch->id)) {
                $batch->cancel(); 
            }
        }
        $userId = Auth::id();
        File::cleanDirectory(storage_path('app/public/images/qrcreate/' . $userId));
        File::cleanDirectory(storage_path('app/public/images/qrzip/' . $userId));
        Session::forget('batch_id');

        return redirect()->route('admin.importCSVView');
    }

    public function exportCSV()
    {
        $name = 'Sample.csv';
        return Excel::download(new SampleCSVExport(), $name);
    }
}
