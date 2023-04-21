<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Hash;

class StaffManagementImport implements ToModel, WithBatchInserts, WithChunkReading, WithStartRow
{
    use Importable;

    /**
     * @param array $row
     * @return User
     */
    public function model(array $row)
    {
        $user = DB::table('users')->where('id', $row[0])->first();
        // Update old data
        if ($user) {
            $dataUpdate = [
                'name' => $row[1],
                'email' => $row[2],
                'password' => Hash::make($row[3]),
                'tel' => $row[4],
                'updated_at' => now(),
                'deleted_at' => null,

            ];
            DB::table('users')->where('id', $row[0])->update($dataUpdate);
        } else {
            // Insert new data
            $user = new User();
            $user->name = $row[1];
            $user->email = $row[2];
            $user->password = Hash::make($row[3]);
            $user->tel = $row[4];
            $user->save();
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
