<?php

namespace App\Exports;

use App\Models\MasterMaterial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterSupplyExport implements FromCollection, WithHeadings
{
    public function headings():array {
        return [
            'ID',
            trans('material.supply_name'),
            trans('material.unit'),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $supplies = MasterMaterial::select(['id', 'name', 'unit'])->where('deleted_at',null)->orderBy('id')->get();
        return $supplies;
    }
}
