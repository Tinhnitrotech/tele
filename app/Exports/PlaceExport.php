<?php

namespace App\Exports;

use App\Models\Place;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlaceExport implements FromCollection, WithHeadings
{
    public function headings():array {
        return [
            'ID',
            trans('place.place_name') ,
            trans('place.place_name_en') ,
            trans('place.phone_number'),
            trans('place.zipcode'),
            trans('place.prefecture'),
            trans('place.address'),
            trans('place.prefecture_en'),
            trans('place.address_en'),
            trans('place.zipcode_default'),
            trans('place.prefecture_default'),
            trans('place.address_default'),
            trans('place.prefecture_default_en'),
            trans('place.address_default_en'),
            trans('place.capacity'),
            trans('place.lat'),
            trans('place.lon'),
            trans('place.altitude'),
            trans('place.status')
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $places = Place::select(['places.id', 'name', 'name_en', 'tel', 'zip_code', 'prefecture_id as prefecture', 'address', 'prefecture_en_id as prefecture_en', 'address_en', 'zip_code_default', 'prefecture_id_default as prefecture_default', 'address_default', 'prefecture_default_en_id as prefecture_default_en', 'address_default_en', 'total_place', 'maps.latitude', 'maps.longitude', 'altitude', 'active_flg'])
                 ->join('maps', 'places.id', 'maps.place_id')
                 ->orderBy('places.id')
                 ->get();
        $places->map(function ($place) {
            $place->prefecture = config('constant.prefectures.' . $place->prefecture);
            $place->prefecture_en = config('constant.prefectures_en.' . $place->prefecture_en);
            $place->prefecture_default = config('constant.prefectures.' . $place->prefecture_default);
            $place->prefecture_default_en = config('constant.prefectures_en.' . $place->prefecture_default_en);
            $place->active_flg = empty($place->active_flg) ? trans('place.status_off') : trans('place.status_on');
        });
        return $places;
    }
}
