<?php

namespace App\Exports;

use App\Models\MasterMaterial;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MasterSupplyImport implements ToModel,WithBatchInserts,WithChunkReading, WithStartRow
{
    use Importable;

    /**
     * @param array $row
     * @return MasterMaterial
     */
    public function model(array $row)
    {
        $material = DB::table('m_supplies')->where('id', $row[0])->first();
        // Update old data
        if($material) {
            $dataUpdate = [
                'name' => $row[1],
                'unit' => $row[2],
                'updated_at' => now(),
                'deleted_at' => null
            ];
            DB::table('m_supplies')->where('id', $row[0])->update($dataUpdate);
        } else {
            // Insert new data
            $material = new MasterMaterial();
            $material->setIncrement(true);
            $material->name = $row[1];
            $material->unit = $row[2];
            $material->save();
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
