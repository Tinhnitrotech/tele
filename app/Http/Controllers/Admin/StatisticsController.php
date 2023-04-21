<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Place\PlaceRepository;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    protected $placeRepository;

    public function __construct(PlaceRepository $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->placeRepository->getStatistics();
        return view('admin.statistics',compact('data'));
    }

    public function ajaxStatus(Request $request)
    {
        $idActive = isset($request->id) ? $request->id : null;
        $data = $this->placeRepository->getStatistics($idActive);
        return response()->json(['data' => $data]);
    }

    public function ajaxGetChart(Request $request)
    {
        $data = $this->placeRepository->getChart($request->id);
        return response()->json(['data' => $data]);
    }
}
