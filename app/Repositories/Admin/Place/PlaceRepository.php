<?php

namespace  App\Repositories\Admin\Place;

use App\Models\Family;
use App\Models\JoinLog;
use App\Models\Map;
use App\Models\MasterMaterial;
use App\Models\NumberPeopleCheckin;
use App\Models\Person;
use App\Models\Place;
use App\Models\Supply;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class PlaceRepository.
 */
class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Place::class;
    }

    /** Create new Place
     *
     * @param $data
     * @return false
     */
    public function createPlace($data) {
        $data['zip_code'] = $data['postal_code_1'].'-'.$data['postal_code_2'];
        $data['zip_code_default'] = $data['postal_code_default_1'].'-'.$data['postal_code_default_2'];
        $data['active_flg'] = isset($data['active_flag']) ? 1 : 0;
        return Place::create($data);
    }

    /** Create Map data when create new Place
     *
     * @param $data
     * @param $place_id
     * @return false
     */
    public function createMapPlace($data, $place_id)
    {
        $data['place_id'] = $place_id;
        return Map::create($data);
    }

    public function getListPlace()
    {
        $listPlace = $this->with(['person', 'family'])->where('active_flg',  config('constant.active'))->paginate(config('constant.paginate_admin_top'));
        $listPlace->map(function ($listPlace) {
            $listPlace->countFamily = count($listPlace->family);
            $listPlace->totalPerson = count($listPlace->person);
            $listPlace->countMale = $listPlace->person->filter(function ($value, $key) {
               return $value->gender == config('constant.male');
            })->count();
            $listPlace->countPregnantWoman = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.pregnant_woman');
            })->count();
			$listPlace->countInfant = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.infant');
            })->count();
			$listPlace->countPersonsWithDisabilities = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.persons_with_disabilities');
            })->count();
			$listPlace->countNursingCareRecipient = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.nursing_care_recipient');
            })->count();
			$listPlace->countMedicalDeviceUsers = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.medical_device_users');
            })->count();
			$listPlace->countAllergies = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.allergies');
            })->count();
			$listPlace->countForeignNationality = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.foreign_nationality');
            })->count();
			$listPlace->countNewbornBaby = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.newborn_baby');
            })->count();

			$listPlace->countOther = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.other');
            })->count();
            $listPlace->countFemale = $listPlace->totalPerson - $listPlace->countMale;
            $listPlace->restSheltered = $listPlace->total_place - $listPlace->totalPerson;
            $countPerson = NumberPeopleCheckin::where('place_id', $listPlace->id)->first();
            if (!empty($countPerson)) {
                $listPlace->countPerson = $countPerson->total_person_checkin;
                $listPlace->rateSheltered = round((($listPlace->totalPerson + $countPerson->total_person_checkin)/$listPlace->total_place)*100, 2);
                $listPlace->countInfant = $listPlace->countInfant + $countPerson->infants;
                $listPlace->countPregnantWoman = $listPlace->countPregnantWoman + $countPerson->pregnant;
                $listPlace->countPersonsWithDisabilities = $listPlace->countPersonsWithDisabilities + $countPerson->disability;
                $listPlace->countNursingCareRecipient = $listPlace->countNursingCareRecipient + $countPerson->caregiver;
                $listPlace->countMedicalDeviceUsers = $listPlace->countMedicalDeviceUsers + $countPerson->medical_device_user;
                $listPlace->countAllergies = $listPlace->countAllergies + $countPerson->allergic;
                $listPlace->countForeignNationality = $listPlace->countForeignNationality + $countPerson->foreign;
                $listPlace->countOther = $listPlace->countOther + $countPerson->other;
                $listPlace->restSheltered = $listPlace->total_place - ($listPlace->totalPerson + $countPerson->total_person_checkin);
            }else{
                $listPlace->countPerson = 0;
                $listPlace->rateSheltered = round(($listPlace->totalPerson/$listPlace->total_place)*100, 2);
            }
            unset($listPlace->family, $listPlace->person);
        });

        return $listPlace;
    }

    public function getListPlaceAdmin()
    {
        $listPlace = $this->orderBy('id')->paginate(config('constant.paginate_admin_top'));
        $listPlace->map(function ($place) {
            $place->address_place = $place->zip_code . ' ' . getChangeAddressName($place->prefecture_id, $place->address, $place->prefecture_en_id, $place->address_en);
            $check = $this->checkActivePlace($place->id, $place->active_flg);
            $place->is_active  = $check;
        });
        return $listPlace;
    }

    /**
     * Get detail Place
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getDetailPlace($id) {
        $detail = $this->with('map')->getById($id);
        $detail->is_active = $this->checkActivePlace($detail->id, $detail->active_flg);
        return $detail;
    }

    /** Get total person place
     *
     * @param $totalPlace
     * @param $placeId
     * @return mixed
     */
    public function getTotalPersonPlace($totalPlace, $placeId) {

        $place = $this->getById($placeId);
        $familyIds = $place->family->pluck('id')->toArray();
        $persons = Person::whereIn('family_id', $familyIds)->get();
        $person_total = $persons->count();
        $persons_checkin = NumberPeopleCheckin::select('total_person_checkin')->where('place_id', $placeId)->first();
        if (!empty($persons_checkin)) {
            $person_total =  $person_total + $persons_checkin->total_person_checkin;
        }
        return $person_total;
    }

    /**
     *  Check Active place can OFF/DELETE
     *
     * @param $id
     * @return bool
     */
    public function checkActivePlace($id, $flg_active){
        $findFamilyInPlace = Family::where(['place_id' => $id])->count();
        if($findFamilyInPlace > 0 && $flg_active == config('constant.active'))  {
            return  true;
        }
        return false;
    }

    /**
     *  Update Place
     *
     * @param $data
     * @param $id
     * @return bool
     */
    public function editPlace($data, $id)
    {
        DB::beginTransaction();
        try {

            if(!isset($data['active_flag']))  {
                $this->destroySupplyPlace($id);
            }

            $placeDetail = Place::find($id);
            $placeMapDetail = Map::where(['place_id' => $id])->first();

            if(!$placeDetail || !$placeMapDetail) {
                return false;
            }

            $data['zip_code'] = $data['postal_code_1'].'-'.$data['postal_code_2'];
            $data['zip_code_default'] = $data['postal_code_default_1'].'-'.$data['postal_code_default_2'];
            $data['active_flg'] = isset($data['active_flag']) ? 1 : 0;
            $dataMap = [
                'longitude' => $data['longitude'],
                'latitude' => $data['latitude']
            ];
            $placeDetail->update($data);
            $placeMapDetail->update($dataMap);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Change status full place
     *
     * @param $id
     * @return bool
     */
    public function changeFullStatus($id) {
        DB::beginTransaction();
        try {
            $placeDetail = Place::findOrFail($id);
            if (!$placeDetail) {
                return false;
            }

            !empty($placeDetail->full_status) ? $full_status = config('constant.place_is_not_full') : $full_status = config('constant.place_is_full');
            Place::where('id', $id)->update(['full_status' => $full_status]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Change status full place
     *
     * @param $id
     * @return bool
     */
    public function changeActiveStatus($id) {
        DB::beginTransaction();
        try {
            $placeDetail = Place::findOrFail($id);
            if (!$placeDetail) {
                return false;
            }

            $check = $this->checkActivePlace($id, $placeDetail->active_flg);
            if($check) {
                return false;
            }

            !empty($placeDetail->active_flg) ? $is_active = config('constant.inactive') : $is_active = config('constant.active');
            Place::where('id', $id)->update(['active_flg' => $is_active]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Delete Place
     *
     * @param $id
     * @return bool
     */
    public function deletePlace($id)
    {
        DB::beginTransaction();
        try {
            $placeDetail = Place::findOrFail($id);
            if (!$placeDetail) {
                return false;
            }

            JoinLog::where(['place_id' => $id])->delete();
            Map::where(['place_id' => $id])->delete();
            $this->destroySupplyPlace($id);
            $this->destroyNumberPeopleCheckin($id);
            $placeDetail->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getShortageSuppliesByPlace($listMasterMaterial)
    {
        $listMasterMaterial = array_values($listMasterMaterial->pluck('id')->toArray());
        $master = array_fill_keys($listMasterMaterial, 0);

//        $data = MasterMaterial::join('supplies', 'supplies.m_supply_id', '=', 'm_supplies.id')
//                ->rightJoin('places','supplies.place_id','=','places.id')
//                ->select(['m_supplies.id as m_supplies_id','places.id as place_id','supplies.number'])
//                ->whereNull('places.deleted_at')
//                ->whereNull('m_supplies.deleted_at')
//                ->whereNull('supplies.deleted_at')
//                ->get();


        $data = Place::select(['m_supplies.id as supplies_id','places.id as place_id','supplies.number'])
            ->leftJoin('supplies', function ($join) {
                $join->on('supplies.place_id','=','places.id');
                $join->whereNull('supplies.deleted_at');
                $join->join('m_supplies', function ($subJoin){
                    $subJoin->on('m_supplies.id','=','supplies.m_supply_id');
                    $subJoin->whereNull('m_supplies.deleted_at');
                });
            })
            ->whereNull('places.deleted_at')
            ->where('active_flg',  config('constant.active'))
            ->get();

        $collect = collect($data)->groupBy('place_id');

        $rs = [];
        foreach ($collect as $placeId => $value) {
            $tmp = $value->pluck('number', 'supplies_id')->filter(function($value, $key){
                return false === empty($key);
            })->toArray();
            $rs[$placeId] = array_replace($master, $tmp);
        }

        $listPlace = Place::select('id','name', 'name_en')->where('active_flg',  config('constant.active'))->with('supplyNote')
            ->get();
        $listPlace->map(function ($listPlace) use ($rs) {
            $listPlace['note'] = $listPlace['supplyNote'] ? $listPlace['supplyNote']['note'] : '';
            $listPlace['comment'] = $listPlace['supplyNote'] ? $listPlace['supplyNote']['comment'] : '';
            $listPlace['supply'] = $rs[$listPlace->id];
        });

       return $listPlace;
    }

    public function getStatistics($idActive = null)
    {
		$listPlace = Place::when($idActive, function ($query, $idActive) {
                return $query->where('id', $idActive);
            })
            ->with(['person', 'family'])->where('active_flg', config('constant.active'))->get();
        $listPlace->map(function ($listPlace) use ($idActive) {
	        $listPlace->totalPerson = count($listPlace->person);
	        $listPlace->countSpecialPerson = $listPlace->person->filter(function ($value, $key) {
			    return $value->option > 0;
		    })->count();
	        $listPlace->countMale = $listPlace->person->filter(function ($value, $key) {
			    return $value->gender == config('constant.male');
		    })->count();

            $listPlace->countPregnantWoman = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.pregnant_woman');
            })->count();
            $listPlace->countInfant = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.infant');
            })->count();
            $listPlace->countPersonsWithDisabilities = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.persons_with_disabilities');
            })->count();
            $listPlace->countNursingCareRecipient = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.nursing_care_recipient');
            })->count();
            $listPlace->countMedicalDeviceUsers = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.medical_device_users');
            })->count();
            $listPlace->countAllergies = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.allergies');
            })->count();
            $listPlace->countForeignNationality = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.foreign_nationality');
            })->count();
            $listPlace->countNewbornBaby = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.newborn_baby');
            })->count();

            $listPlace->countOther = $listPlace->person->filter(function ($value, $key) {
                return $value->option == config('constant.person_requiring_option.other');
            })->count();

            $listPlace->checked = true;
            $listPlace->name = getTextChangeLanguage($listPlace->name, $listPlace->name_en);
	        unset($listPlace->family, $listPlace->person);
        });
	    $totalPerson = 0;
		$totalSpecialPerson = 0;
		$totalMale = 0;
		$totalPersonPlace = 0;
		foreach ($listPlace as $value) {
			$totalPerson += $value->totalPerson;
			$totalSpecialPerson += $value->countSpecialPerson;
			$totalMale += $value->countMale;
			$totalPersonPlace += $value->total_place;

		}

		$data = [
			'list_place' => $listPlace,
//			'person_percent' => number_format(($totalPerson/$totalPersonPlace)*100, 2),
//			'person_special_percent' => number_format(($totalSpecialPerson/$totalPerson)*100, 2),
//			'male_percent' => number_format(($totalMale/$totalPerson)*100, 2),
//			'female_percent' => number_format((($totalPerson - $totalMale)/$totalPerson)*100, 2),
//			'total_person_place' => $totalPersonPlace,
		];

        return $data;
    }

    public function getChart($id)
    {
        $place = Place::with(['person', 'family'])->where('id', $id)
            ->where('active_flg', config('constant.active'))
            ->first();

        $totalPerson = isset($place->person) ? $place->person->count() : 0;
        $totalSpecialPerson = isset($place->person) ? $place->person->filter(function ($value, $key) {
            return $value->option > 0;
        })->count() : 0;
        $totalMale = isset($place->person) ? $place->person->filter(function ($value, $key) {
            return $value->gender == config('constant.male');
        })->count() : 0;

        $data = [
            'id' => $place->id,
            'person_special' => $totalSpecialPerson,
            'male_percent' => $totalMale,
            'female_percent' => $totalPerson - $totalMale,
            'total_person_place' => $totalPerson,
        ];

        return $data;
    }

    /** Destroy supply
     *
     * @param $id
     */
    public function destroySupplyPlace($id)
    {
        return Supply::where(['place_id' => $id])->delete();
    }

    public function destroyNumberPeopleCheckin($id)
    {
        return NumberPeopleCheckin::where(['place_id' => $id])->delete();
    }

    /** Get info list place active
     *
     * @return mixed
     */
    public function getAllPlaceInfo()
    {
        $places = Place::with('map')->select('id','name', 'name_en', 'zip_code', 'total_place', 'address', 'prefecture_id',  'address_en', 'prefecture_en_id', 'active_flg', 'full_status', 'altitude')->whereNull('deleted_at')->get();
        $places->map(function ($place) {
            $place->address_place = $place->zip_code . ' ' . getChangeAddressName($place->prefecture_id, $place->address, $place->prefecture_en_id, $place->address_en);
            $place->total_person = $this->getTotalPersonPlace($place->total_place, $place->id);
            $place->percent = round(($place->total_person / $place->total_place) * 100, 2);
            $place->lat = isset($place['map']['latitude']) ? $place['map']['latitude'] : '';
            $place->altitude = !empty($place->altitude) ? $place->altitude . 'm' : '-';
            $place->lng = isset($place['map']['longitude']) ? $place['map']['longitude'] : '';;
            $place->url = route('userDashboard') . '?hinan=' . $place->id;
            $place->name = getTextChangeLanguage($place->name,  $place->name_en);
        });
        return $places;
    }

    /** Get info list place active
     *
     * @return mixed
     */
    public function getAllPlaceActiveInfo()
    {
        $places = Place::with('map')->select('id','name', 'zip_code', 'total_place', 'address', 'prefecture_id', 'full_status')->where(['active_flg' =>  config('constant.active')])->whereNull('deleted_at')->get();
        $places->map(function ($place) {
            $place->address_place = $place->zip_code . ' ' . config('constant.prefectures.' . $place->prefecture_id) . $place->address;
            $place->total_person = $this->getTotalPersonPlace($place->total_place, $place->id);
            $place->percent = round(($place->total_person / $place->total_place) * 100, 2);
            $place->lat = isset($place['map']['latitude']) ? $place['map']['latitude'] : '';;
            $place->lng = isset($place['map']['longitude']) ? $place['map']['longitude'] : '';;
        });
        return $places;
    }

    /** Get info list place active
     *
     * @return mixed
     */
    public function getPlaceDetailInfo($id)
    {
        $place = Place::with('map')->select('id','name', 'zip_code', 'total_place', 'address', 'prefecture_id', 'full_status', 'altitude')->where(['id' =>  $id])->whereNull('deleted_at')->first();
            $place->address_place = $place->zip_code . ' ' . config('constant.prefectures.' . $place->prefecture_id) . $place->address;
            $place->total_person = $this->getTotalPersonPlace($place->total_place, $place->id);
            $place->percent = round(($place->total_person / $place->total_place) * 100, 2);
            $place->lat = isset($place->map->latitude) ? $place->map->latitude : '';
            $place->lng = isset($place->map->longitude) ? $place->map->longitude : '';
        return $place;
    }

    /** Filter Place list
     *
     * @param $places
     * @param $place
     * @return int
     */
    public function filterPlaces($places, $id) {
        $placeDetail = [];
        foreach ($places as $key => $place) {
            if($place->id == $id) {
                $placeDetail = $places[$key];
                unset($places[$key]);
                $places->prepend($placeDetail);
            }
        }
        return $places;

    }
}
