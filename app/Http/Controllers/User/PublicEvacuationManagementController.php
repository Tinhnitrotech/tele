<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Staff\Person\PersonRepository;
use Illuminate\Http\Request;

class PublicEvacuationManagementController extends Controller
{
    public $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function index(Request $request)
    {
        $data = $this->personRepository->getPublicPersonByFamily($request);
        $data->name = $request->name ?? '';
        $data->display_option = $request->display_option ?? '';
        return view('user.public_evacuation',compact('data'));
    }
}
