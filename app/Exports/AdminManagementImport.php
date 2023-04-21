<?php

namespace App\Exports;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Hash;

class AdminManagementImport implements ToModel, WithBatchInserts, WithChunkReading, WithStartRow
{
    use Importable;

    /**
     * @param array $row
     * @return Admin
     */
    public function model(array $row)
    {
        $admin = DB::table('admins')->where('id', $row[0])->first();
        // Update old data
        if ($admin) {
            $dataUpdate = [
                'name' => $row[1],
                'email' => $row[2],
                'password' => Hash::make($row[3]),
                'updated_at' => now(),
                'deleted_at' => null,

            ];
            DB::table('admins')->where('id', $row[0])->update($dataUpdate);
        } else {
            // Insert new data
            $admin = new Admin();
            $admin->name = $row[1];
            $admin->email = $row[2];
            $admin->password = Hash::make($row[3]);
            $admin->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
