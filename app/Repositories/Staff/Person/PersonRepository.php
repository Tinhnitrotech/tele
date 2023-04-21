<?php

namespace App\Repositories\Staff\Person;

use App\Models\Family;
use App\Models\NumberPeopleCheckin;
use App\Models\Person;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class PersonRepository.
 */
class PersonRepository extends BaseRepository implements PersonRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Person::class;
    }

    /**
     * Get Data Not Delete
     */
    public function isNotDelete()
    {
        return $this->where('deleted_at', null);
    }

    /**
     * Get List Person
     *
     * @param $request Illuminate\Http\Request
     * @return Person
     */
    public function getListPerson($request)
    {
        $familyId = $request->family_id ?? null;
        $name = $request->name ?? null;

        $query = $this->isNotDelete();
        if (!empty($familyId)) {
            $query = $query->where('family_id', $familyId);
        }

        if (!empty($name)) {
            $query = $query->where('name', '%' . $name . '%', 'like');
        }
        $listPerson = $query->paginate(config('constant.paginate_admin_top'));
        return $listPerson;
    }

    /**
     * @param int $familyId
     * @param int $page
     *
     * @return int
     */
    public function countPersonByPage($familyId, $page)
    {
        $count = 0;
        if ($page > 1) {
            $listPerson = $this->isNotDelete()->limit(($page - 1) * config('constant.paginate_admin_top'))->get();
            $personFilter = $listPerson->filter(function($person) use ($familyId) {
                return $person->family_id == $familyId;
            });

            $count = $personFilter->count();
        }

        return $count;
    }

    /**
     * Create Person By Family ID
     *
     * @param int $familyId
     * @param $request Illuminate\Http\Request
     */
    public function createPersonByFamily($familyId, $request)
    {
        $persons = $request->person;
        $dataPerson = array_filter($persons, function ($value) {
            return $value['name'] != null;
        });
        $ownerRow = $request->is_owner;
        if (!empty($dataPerson)) {
            foreach ($dataPerson as $key => $person) {
                $data = [
                    'family_id' => $familyId,
                    'name' => handleFileNamePerson($person['name']),
                    'age' => !empty($person['age']) ? (int) $person['age'] : 0,
                    'gender' => !empty($person['gender']) ? (int) $person['gender'] : 1,
                ];

                if (!empty($person['option']) && $person['option'] != "--") {
                    $data['option'] = $person['option'];
                }

                if (!empty($person['note'])) {
                    $data['note'] = $person['note'];
                }

                if ($person['id'] == (int) $ownerRow) {
                    $data['is_owner'] = 0;
                }

                $this->model->create($data);
            }
        }
    }

    /**
     * Edit Person By Family ID
     *
     * @param int $familyId
     * @param $request Illuminate\Http\Request
     */
    public function editPersonByFamily($familyId, $request)
    {
        $persons = array_values($request->person);
        $ownerRow = $request->is_owner;

        $personsOld = $this->getPersonByFamilyId($familyId);
        $listPersonIds = [];
        foreach ($personsOld as $personOld) {
            $listPersonIds[] = $personOld->id;
        }

        $listPersonIdsUpdate = $listPersonIds;

        if (!empty($request->remove_person_ids)) {
            $removePersonIds = explode(',', $request->remove_person_ids);

            /** Remove Person */
            $this->deleteMultipleById($removePersonIds);

            $listPersonIdsUpdate = array_diff($listPersonIds, $removePersonIds);
        }

        $listPersonIdsUpdate = array_values($listPersonIdsUpdate);

        $dataPerson = array_filter($persons, function ($value) {
            return $value['name'] != null;
        });
        foreach ($dataPerson as $key => $person) {
            $data = [
                'family_id' => $familyId,
                'name' => handleFileNamePerson($person['name']),
                'age' => !empty($person['age']) ? (int) $person['age'] : 0,
                'gender' => !empty($person['gender']) ? (int) $person['gender'] : 1,
            ];

            if (!empty($person['option']) && $person['option'] != "--") {
                $data['option'] = $person['option'];
            }

            if (!empty($person['note'])) {
                $data['note'] = $person['note'];
            }

            if (($key + 1) == (int) $ownerRow) {
                $data['is_owner'] = 0;
            } else {
                $data['is_owner'] = 1;
            }

            /** Update Person */
            if (sizeof($listPersonIdsUpdate) > 0 && !empty($listPersonIdsUpdate[$key])) {
                $this->updateById($listPersonIdsUpdate[$key], $data);
            } else {
                /** Create New Person */
                $this->model->create($data);
            }
        }
    }

    /**
     * @param int $familyId
     *
     * @return Person
     */
    public function getPersonByFamilyId($familyId)
    {
        $data = $this->isNotDelete()->where('family_id', $familyId)->get();
        return $data;
    }

    /**
     * @param collection $families
     *
     * @return array $data
     */
    public function getTotalFamily($families)
    {
        $data = [
            'person_total' => 0,
            'person_male' => 0,
            'person_female' => 0,
            'person_less_12' => 0,
            'total_person_checkin' => 0
        ];

        if ($families->isNotEmpty()) {
            $familyIds = $families->pluck('id')->toArray();
            $numberPeople = NumberPeopleCheckin::where('place_id', getPlaceID())->first();
            if(is_null($numberPeople)) {
                $total_person_staff_add = 0;
            } else {
                $total_person_staff_add = $numberPeople->total_person_checkin;
            }
            $persons = $this->whereIn('family_id', $familyIds)->get();
            if ($persons->isNotEmpty()) {
                $data['person_total'] = $persons->count();
                $data['total_person_checkin'] = $persons->count() + $total_person_staff_add;
                $data['total_family'] = $this->countTotalFamily();
                $data['person_male'] = $persons->filter(function($value) {
                    return $value->gender == config('constant.male');
                })->count();
                $data['person_female'] = $persons->filter(function($value) {
                    return $value->gender == config('constant.female');
                })->count();
                $data['person_less_12'] = $persons->filter(function($value) {
                    return $value->age <= 12;
                })->count();
                $data['count_person'] = $total_person_staff_add;

                $data['pregnant_woman'] = $persons->filter(function($value) {
                    return $value->option == config('constant.person_requiring_option.pregnant_woman');
                })->count();
                $data['infant'] = $persons->filter(function($value) {
                    return $value->option == config('constant.person_requiring_option.infant');
                })->count();
                $data['persons_with_disabilities'] = $persons->filter(function($value) {
                    return $value->option == config('constant.person_requiring_option.persons_with_disabilities');
                })->count();
                $data['nursing_care_recipient'] = $persons->filter(function($value) {
                    return $value->option == config('constant.person_requiring_option.nursing_care_recipient');
                })->count();
                $data['medical_device_users'] = $persons->filter(function($value) {
                    return $value->option == config('constant.person_requiring_option.medical_device_users');
                })->count();
                $data['allergies'] = $persons->filter(function($value) {
                    return $value->option == config('constant.person_requiring_option.allergies');
                })->count();
                $data['foreign_nationality'] = $persons->filter(function($value) {
                    return $value->option == config('constant.person_requiring_option.foreign_nationality');
                })->count();
                $data['other'] = $persons->filter(function($value) {
                    return $value->option == config('constant.person_requiring_option.other');
                })->count();

                $countPerson = NumberPeopleCheckin::where('place_id', getPlaceID())->first();
                if($countPerson) {
                    $data['infant'] = $data['infant'] + $countPerson->infants;
                    $data['pregnant_woman'] = $data['pregnant_woman'] + $countPerson->pregnant;
                    $data['persons_with_disabilities'] = $data['persons_with_disabilities'] + $countPerson->disability;
                    $data['nursing_care_recipient'] = $data['nursing_care_recipient'] + $countPerson->caregiver;
                    $data['medical_device_users'] = $data['medical_device_users'] + $countPerson->medical_device_user;
                    $data['allergies'] =  $data['allergies'] + $countPerson->allergic;
                    $data['foreign_nationality'] = $data['foreign_nationality'] + $countPerson->foreign;
                    $data['other'] = $data['other'] + $countPerson->other;
                }
            }
        }

        return $data;
    }

    /** Count total family place
     *
     * @return mixed
     */
    public function countTotalFamily($request = null,$isAdmin = false) {
        $placeId = getPlaceID();
       if ($isAdmin) {
           $placeId = $request->place_id ?? null;
       }
       $familyCode = $request->family_code ?? null;
       $name = $request->name ?? null;
       $total_family = Family::when(!empty($placeId), function ($query) use ($placeId) {
           return $query->where('families.place_id', $placeId);
       })->when(!empty($familyCode), function ($query) use ($familyCode) {
           return $query->where('family_code', $familyCode);
       })->when(!empty($name), function ($query) use ($name) {
           return $query->whereHas('person', function($query) use ($name) {
               $query->where('persons.name', 'Like', '%' . $name . '%');
           });
       })->whereNull('families.deleted_at')->count();
       return $total_family;
    }

    /**
     * Get total person have option
     *
     * @param $families
     * @return int[]
     */
    public function getTotalPersonOption($families) {

        $data = [];

        if ($families->isNotEmpty()) {
            $familyIds = $families->pluck('id')->toArray();

            $persons = $this->whereIn('family_id', $familyIds)->get();
            if ($persons->isNotEmpty()) {
                $data['person_total'] = $persons->count();

               foreach (trans('common.person_requiring_option') as $key => $val) {
                    $data['person_option_'.$key] = $persons->filter(function($value) use ($key) {
                        return $value->option == $key;
                    })->count();
                }
            }
        }

        return $data;
    }

    public function getPersonByFamily($placeId,$request, $csv = null)
    {
        $familyCode = $request->family_code ?? null;
        $name = $request->name ?? null;
        $columns = ['family_id', 'family_code', 'is_owner','persons.name as personName','gender','age','option','places.name as placeName', 'places.name_en as placeNameEn', 'note','join_date',
            'out_date','persons.created_at as created_at','persons.id as personId', 'family_code'];

        $listResult = Person::leftjoin('families', 'persons.family_id', '=', 'families.id')
            ->leftjoin('places','families.place_id', '=', 'places.id')
            ->select($columns)
            ->where('families.deleted_at', null)
            ->when(!empty($placeId), function ($query) use ($placeId) {
                return $query->where('families.place_id', $placeId);
            })->when(!empty($familyCode), function ($query) use ($familyCode) {
                return $query->where('family_code', $familyCode);
            })->when(!empty($name), function ($query) use ($name) {
                return $query->where('persons.name', 'Like', '%' . $name . '%');
            })->orderBy('family_id')->get();

        $key_array = array_values(array_unique($listResult->pluck('family_id')->toArray()));
        $new_array = array();
        $dataCustom = array();
        foreach ($key_array as $item) {
            $i = 0;
            foreach ($listResult->toArray() as $val) {
                if ($item == $val['family_id']) {
                    $new_array[] = $val;
                    $i++;
                }
            }
            $data =$this->sortOwner($new_array, $i);
            foreach ($data as $key  => $person) {
                $person['index'] = $key + 1;
                $dataCustom[] = $person;
            }
            $new_array = array();
        }
        $data = !$csv ? $this->handlePaginate($dataCustom,$request) : $dataCustom;
        return $data;
    }

    public function getPublicPersonByFamily($request, $csv = null)
    {
        $name = $request->name ?? null;
        $columns = ['family_id', 'family_code', 'is_owner', 'persons.id as personId', 'persons.name as personName', 'age',
                    'places.name as placeName', 'places.name_en as placeNameEn', 'families.zip_code', 'families.prefecture_id', 'families.address_default'];

        $listResult = Person::leftjoin('families', 'persons.family_id', '=', 'families.id')
            ->leftjoin('places','families.place_id', '=', 'places.id')
            ->select($columns)
            ->where('families.deleted_at', null)
            ->where('families.public_info', 1)
            ->when(!empty($name), function ($query) use ($name) {
                return $query->where('persons.name', 'Like', '%' . $name . '%');
            })->orderBy('family_id')->get();

        $key_array = array_values(array_unique($listResult->pluck('family_id')->toArray()));
        $new_array = array();
        $dataCustom = array();
        foreach ($key_array as $item) {
            $i = 0;
            foreach ($listResult->toArray() as $val) {
                if ($item == $val['family_id']) {
                    $new_array[] = $val;
                    $i++;
                }
            }
            $data =$this->sortOwner($new_array, $i);
            foreach ($data as $key  => $person) {
                $person['index'] = $key + 1;
                $dataCustom[] = $person;
            }
            $new_array = array();
        }
        $data = !$csv ? $this->handlePaginate($dataCustom,$request) : $dataCustom;
        return $data;
    }

    public function sortOwner($array, $key)
    {
        for($i = 0; $i <= $key-1; $i++ ) {
            if($array[$i]['is_owner'] == 0) {
                $tmp = $array[$i];
                $array[$i] = $array[0];
                $array[0] = $tmp;
            }
        }
        return $array;
    }

    public function handlePaginate($items, $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $perPage = config('constant.paginate_admin_top');
        $offset = ($page * $perPage) - $perPage;
        $entries = new LengthAwarePaginator(
            array_slice($items, $offset, $perPage, true),
            count($items),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        return $entries;
    }
}
