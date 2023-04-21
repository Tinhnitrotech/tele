<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Place\PlaceRepository;
use App\Repositories\Staff\Person\PersonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
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
     * Staff DashBoardController Construct
     */
    public function __construct(PlaceRepository $placeRepository, PersonRepository $personRepository)
    {
        $this->placeRepository = $placeRepository;
        $this->personRepository = $personRepository;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $place = null;
        $personTotal = null;
        try {
            $placeId = getPlaceID();
            $place = $this->placeRepository->getDetailPlace($placeId);
            if (!empty($place->family)) {
                $personTotal = $this->personRepository->getTotalFamily($place->family);
            }
        } catch (\Exception $e) {
            report($e);
        }

        return view('staff.index', compact('place', 'personTotal'));
    }

    /**
     * @return View Login Form
     */
    public function logout()
    {
        Auth::guard('staff')->logout();

        return redirectRouteByPlaceId('staff.staffLogin');
    }
}
