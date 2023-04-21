<?php

namespace App\Exports;

use App\Repositories\Staff\Person\PersonRepository;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FamilyExport implements FromCollection, WithHeadings
{
    public $formRequest;

    public function __construct($formRequest)
    {
        $this->formRequest = $formRequest;
    }

    public function headings():array
    {
        return [
            'ID',
            trans('staff_refuge_index.th_2'),
            trans('staff_refuge_index.th_3'),
            trans('staff_refuge_index.th_4'),
            trans('staff_refuge_index.th_5'),
            trans('staff_refuge_index.th_6'),
            trans('staff_refuge_index.th_7'),
            trans('staff_refuge_index.th_8'),
            trans('staff_refuge_index.place_name'),
            trans('staff_refuge_index.place_name_en'),
            trans('staff_refuge_index.th_9'),
            trans('staff_refuge_index.checkout'),
            trans('staff_refuge_index.th_10'),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $person = new PersonRepository();
        $placeId = $this->formRequest->place_id;
        $families = new Collection($person->getPersonByFamily($placeId,$this->formRequest,1));
        $reportOut = $families->map(function ($person) {
            array_splice( $person, 1, 0, $person['index'] );
            $person['is_owner'] = empty($person['is_owner']) ? trans('staff_refuge_index.representative') : '';
            $person['placeNameEn'] = empty($person['placeName']) ? trans('evacuation_management.no_place') : getTextChangeLanguage('-', $person['placeNameEn']);
            $person['placeName'] = empty($person['placeName']) ? trans('evacuation_management.no_place') : $person['placeName'];
            $person['gender'] = getGenderName($person['gender']);
            $person['option'] = $person['option'] ? trans('common.person_requiring_option')[$person['option'] ]: '';
            $person['out_date'] = $person['out_date'] ? date('Y/m/d', strtotime($person['out_date'])):'';
            $person['created_at'] = $person['created_at'] ? date('Y/m/d', strtotime($person['created_at'])):'';
            unset($person['index'], $person['join_date'], $person['personId']);
            return $person;
        });
        return $reportOut;
    }
}
