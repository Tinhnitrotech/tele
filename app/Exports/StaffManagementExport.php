<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class StaffManagementExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID',
            trans('staff_management.name_no_kana'),
            trans('staff_management.email'),
            trans('common.password'),
            trans('staff_management.tel'),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $staffs = User::select(['id', 'name', 'email', 'password', 'tel'])->where('deleted_at', null)->orderBy('id')->get()->makeVisible(['password']);
       
        return $staffs;
    }

}
