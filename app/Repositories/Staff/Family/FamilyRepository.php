<?php

namespace App\Repositories\Staff\Family;

use App\Models\Family;
use App\Models\JoinLog;
use App\Models\Person;
use App\Repositories\Admin\Place\PlaceRepository;
use App\Repositories\Staff\JoinLog\JoinLogRepository;
use App\Repositories\Staff\Person\PersonRepository;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Filesystem\Filesystem;

//use Your Model

/**
 * Class FamilyRepository.
 */
class FamilyRepository extends BaseRepository implements FamilyRepositoryInterface
{
    /**
     * @var personRepository
     */
    protected $personRepository;

    /**
     * @var joinLogRepository
     */
    protected $joinLogRepository;

    /**
     * StaffRepository constructor.
     *
     * @param PersonRepository       $personRepository
     * @param JoinLogRepository       $joinLogRepository
     */
    public function __construct(PersonRepository $personRepository, JoinLogRepository $joinLogRepository)
    {
        $this->makeModel();
        $this->personRepository = $personRepository;
        $this->joinLogRepository = $joinLogRepository;
    }

    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Family::class;
    }

    /**
     * Get Data Not Delete
     */
    public function isNotDelete()
    {
        return $this->where('deleted_at', null);
    }

    /**
     * Create Family
     *
     * @param $request Illuminate\Http\Request
     *
     * @return Family
     */
    public function createAddFamily($request)
    {
        $data = $this->getAttributes($request);
        $data['address'] = handleAddressCSV($request['address']);
        return $this->model->create($data);
    }

    /**
     * @param $request Illuminate\Http\Request
     * @param $edit bool
     *
     * @return array
     */
    public function getAttributes($request, $edit = false)
    {
        $join_date_create = date_create($request->join_date);
        $join_date = date_format($join_date_create, 'Y-m-d H:i:s');
        $public_info = isset($request->public_info) ? 1 : 0;
        $zip_code = $request->postal_code_1 . '-' .$request->postal_code_2;
        $is_public = 0;
        if (!empty($request->is_public) && $request->is_public == 'on') {
            $is_public = 1;
        }

        $addressDefault = isset($request->address_default) ? $request->address_default : $request->address;
        $addressDefaultArr = preg_replace('/[\d−－ー]+/u', '', $addressDefault);
        $addressDefaultArr = preg_replace('/番地の?/u', '', $addressDefaultArr);

        $data = [
            'join_date' => $join_date,
            'zip_code' => $zip_code,
            'prefecture_id' => $request->prefecture_id,
            'address' => handleAddressCSV($request->address),
            'address_default' => handleAddressCSV($addressDefaultArr),
            'tel' => handleTelQRCode($request->tel),
            'is_public' => $is_public,
            'public_info' => $public_info,
            'language_register' => App::getLocale(),
        ];

        if (!$edit) {
            $data['place_id'] = getPlaceID();
        }

        if ($edit) {
            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }
        } else {
            $data['password'] = Hash::make($request->password);
        }

        return $data;
    }

    /**
     * @param Illuminate\Http\Request $request
     * @return array|false
     */
    public function createAddFamilyAndPerson($request)
    {
        DB::beginTransaction();
        try{
            $family = $this->createAddFamily($request);
            $familyCode = getFamilyCode(getPlaceID(), $family->id);
            $family->update(['family_code' => $familyCode]);
            $this->personRepository->createPersonByFamily($family->id, $request);

            // Create QR code
            $this->saveQRCode($family->id);

            /**
             * Create Log
             */
            $datetime = Carbon::now();
            $access_datetime = $datetime->toDateTimeString();
            $data = [
                'family_id' => $family->id,
                'prefecture_id' => $family->prefecture_id,
                'place_id' => $family->place_id,
                'status' => config('constant.status_checkin'), // checkIn
                'access_datetime' => $access_datetime
            ];
            $this->joinLogRepository->createJoinLog($data);
            $dataReturn = [
                'family_id' => $family->id,
                'family_code' => $familyCode
            ];
            DB::commit();
            return $dataReturn;
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param $request Illuminate\Http\Request
     *
     * @return bool
     */
    public function editAddFamilyAndPerson($request, $id)
    {
        DB::beginTransaction();
        try{
            $data = $this->getAttributes($request, true);
            $family = $this->updateById($id, $data);
            $this->personRepository->editPersonByFamily($family->id, $request);
            if($family->qr_code) {
                $file = new Filesystem();
                $file->cleanDirectory('storage/images/qr/' . $family->id);
            }
            $this->saveQRCode($family->id);
            $family->touch();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param $familyId
     */
    public function saveQRCode($familyId)
    {
        $data = $this->getDataAttributeFamily($familyId);
        $dataQr = encryptData(json_encode($data));
        $image = QrCode::format('png')
            ->size(450)->errorCorrection('H')
            ->margin(4)
            ->backgroundColor(255,255,255)
            ->generate($dataQr);
        $output_file = 'images/qr/' . $familyId . '/' . time() . '.png';
        Storage::disk('public')->put($output_file, $image);
        Family::find($familyId)->update(['qr_code' => $output_file]);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getFamilyById($id)
    {
        $result = $this->isNotDelete()->with('person')->getById($id);
        return $result;
    }

    public function getHistoryCheckInByFamilyId($id,$request)
    {
        $result = JoinLog::select('place_id','status','access_datetime','places.name as placeName', 'places.name_en as placeNameEn')
            ->join('places', 'join_logs.place_id', '=', 'places.id')->whereFamilyId($id)
            ->orderBy('join_logs.id', 'asc')->get()->toArray();
        $history = array();
        if (count($result) > 0) {
            // get 2 item order access_datetime desc
            $listJoinLog = array_chunk($result, 2);

            // reverse key
            krsort($listJoinLog);
            $history = handlePaginate($listJoinLog, $request);
        }
        return $history;
    }

    /**
     * @param null | int $id
     *
     * @return array $data
     */
    public function getDataAttribute($id = null)
    {
        $placeRepo = new PlaceRepository();
        $place = $placeRepo->getById(getPlaceID())->toArray();
        $postal_code = explode('-', $place['zip_code_default']);
        $data = [
            'join_date' => date('Y/m/d'),
            'postal_code_1' => isset($postal_code[0]) ? $postal_code[0] : old('postal_code_1'),
            'postal_code_2' => isset($postal_code[1]) ? $postal_code[1] : old('postal_code_2'),
            'prefecture_id' => isset($place['prefecture_id_default']) ? getTextLanguageAddress($place['prefecture_id_default'], $place['prefecture_default_en_id']) : old('prefecture_id'),
            'address' => isset($place['address_default']) ? getTextLanguageAddress($place['address_default'], $place['address_default_en'])  : old('address'),
            'tel' => old('tel'),
            'password' => old('password'),
            'is_public' => null,
            'public_info' => null,
            'person' => null,
        ];

        if (!empty($id)) {
            $family = $this->getFamilyById($id);

            if ($family) {
                $zipCode = !empty($family->zip_code) ? explode('-', $family->zip_code) : [];
                $data = [
                    'id' => $id,
                    'join_date' => date('Y/m/d', strtotime($family->join_date)),
                    'postal_code_1' => $zipCode[0],
                    'postal_code_2' => $zipCode[1],
                    'prefecture_id' => $family->prefecture_id,
                    'address' => $family->address,
                    'tel' => $family->tel,
                    'is_public' => $family->is_public,
                    'public_info' => $family->public_info,
                    'person' => !empty($family->person) ? $family->person->toArray() : null,
                ];
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getFamilyPersonByPlaceID()
    {
        $placeId = getPlaceID();
        $families = $this->isNotDelete()->with('person')->where('place_id', $placeId)->get();
        $personTotal = $this->personRepository->getTotalFamily($families);

        return $personTotal;
    }

    /**
     * @return bool
     */
    public function checkPlaceTotal()
    {
        $placeTotal = getTotalPlaceByID();
        $personTotal = $this->getFamilyPersonByPlaceID();
        $countPerson = $personTotal['person_total'];

        if (($placeTotal - $countPerson) < 0) {
            return false;
        }

        return true;
    }

    public function getDetailFamily($id)
    {
        $family = $this->getById($id);
        $family->prefecture_name = $family->language_register == config('constant.language_ja') ? get_prefecture_name($family->prefecture_id) : get_prefecture_name_en($family->prefecture_id);
        $family->person = Family::find($id)->person()->get();
        return $family;
    }

    /** Get json family data
     *
     * @param $id
     * @return array
     */
    public function getDataAttributeFamily($id)
    {
        $family = $this->getById($id);
        $family->prefecture_name = $family->language_register == config('constant.language_ja') ? get_prefecture_name($family->prefecture_id) : get_prefecture_name_en($family->prefecture_id);
        $persons = Family::find($id)->person()->get();

        foreach ($persons as $person) {
            $postal_code = explode('-', $family->zip_code);
            $dataAtt[] = [
                '0' => $person->name,
                '1' => $postal_code[0],
                '2' => $postal_code[1],
                '3' => $family->address,
                '4' => $family->tel,
                '5' => $person->is_owner,
            ];
        }

        return $dataAtt;
    }

    /**
     * @param $persons
     * @param $tel
     *
     * @return bool
     */
    public function checkPersonIsExistsInFamily($persons, $tel)
    {
        foreach ($persons as $person) {
            $families = Family::whereHas('person', function ($query) use ($person) {
                $query->where('name', $person['name'])->where('gender', $person['gender']);
            })->where('tel', $tel)->get();
            if (!$families->isEmpty()) {
                return true;
            }
        }
        return false;

    }

    /**
     * @param $request Illuminate\Http\Request
     *
     * @return bool
     */
    public function checkEditPersonIsExistsInFamily($request)
    {
        $newPersons = $request->person;
        foreach ($newPersons as $newPerson) {
            $persons = Person::whereHas('family', function ($query) use ($request) {
                $query->where('tel', $request->tel);
            })->where('name', $newPerson['name'])->where('gender', $newPerson['gender'])->first();

            if ($persons && $persons['id'] != $newPerson['id']) {
                return true;
            }
        }
        return false;

    }

}
