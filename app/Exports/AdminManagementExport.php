<?php

namespace App\Exports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class AdminManagementExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID',
            trans('admin_management.name_no_kana'),
            trans('admin_management.email'),
            trans('common.password'),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $admins = Admin::select(['id', 'name', 'email', 'password'])->where('deleted_at', null)->orderBy('id')->get();
        return $admins;
    }
}
