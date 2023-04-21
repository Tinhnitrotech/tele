<?php

namespace App\Exports;

use App\Models\Supply;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplyExport implements FromCollection, WithHeadings
{
    public function headings():array {
        return [
            'ID',
            trans('staff_supplies_index.place_name'),
            trans('staff_supplies_index.place_name_en'),
            trans('staff_supplies_index.substance'),
            trans('staff_supplies_index.number'),
            trans('staff_supplies_index.quantity'),
            trans('staff_supplies_index.comment'),
            trans('staff_supplies_index.note')
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $supplies = Supply::select(['supplies.id as id', 'places.name as placeName', 'places.name_en as placeNameEn', 'm_supplies.name as name', 'supplies.number as number', 'm_supplies.unit as unit', 'supply_notes.comment as comment', 'supply_notes.note as note'])
                 ->join('places', 'places.id', 'supplies.place_id')
                 ->leftjoin('supply_notes', 'supply_notes.place_id', 'supplies.place_id')
                 ->join('m_supplies', 'm_supplies.ID', 'supplies.m_supply_id')
                 ->where('places.active_flg','=', config('constant.active'))
                 ->get();
        $supplies->map(function ($place) {
            $place->placeName = empty($place->placeName) ? '-' : $place->placeName;
            $place->placeNameEn = empty($place->placeNameEn) ? '-' : $place->placeNameEn;
            $place->unit = empty($place->unit) ? '-' : $place->unit;
            $place->number = empty($place->number) ? '0' : $place->number;
            $place->comment = empty($place->comment) ? '-' : $place->comment;
            $place->note = empty($place->note) ? '-' : $place->note;
        });
        return $supplies;
    }
}
