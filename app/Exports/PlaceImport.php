<?php

namespace App\Exports;

use App\Models\Map;
use App\Models\Place;
use App\Repositories\Admin\Place\PlaceRepository;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;


class PlaceImport implements ToModel,WithBatchInserts,WithChunkReading, WithStartRow
{

    use Importable;

    /**
     * @param array $row
     * @return Place
     */
    public function model(array $row)
    {
        $place = DB::table('places')->where('id', $row[0])->first();

        // Update old data
        if($place) {

            if($row[18] && ($row[18] == '有効' || $row[18] == 'On')) {
                $active_flg = 1;
            } else {
                $active_flg = 0;
            }

            if(empty($active_flg)) {
                $placeDetail = new PlaceRepository();
                $checkActivePlace = $placeDetail->checkActivePlace($place->id, $place->active_flg);
                if ($checkActivePlace) {
                    return true;
                }
            }

            $dataUpdate = [
                'name' => $row[1],
                'name_en' => $row[2],
                'tel' => $row[3],
                'zip_code' => $row[4],
                'prefecture_id' => get_prefecture_id_by_name($row[5]),
                'address' => $row[6],
                'prefecture_en_id' => get_prefecture_id_by_name_en($row[7]),
                'address_en' => $row[8],
                'zip_code_default' => $row[9],
                'prefecture_id_default' => get_prefecture_id_by_name($row[10]),
                'address_default' => $row[11],
                'prefecture_default_en_id' => get_prefecture_id_by_name_en($row[12]),
                'address_default_en' => $row[13],
                'total_place' => $row[14],
                'altitude' => $row[17],
                'active_flg' => $active_flg,
                'updated_at' => now(),
                'deleted_at' => null
            ];

            $mapUpdate = [
                'latitude' => $row[15],
                'longitude' => $row[16],
                'updated_at' => now(),
                'deleted_at' => null
            ];

            DB::table('places')->where('id', $row[0])->update($dataUpdate);
            DB::table('maps')->where('place_id', $row[0])->update($mapUpdate);

        } else {

            if($row[18] && ($row[18] == '有効' || $row[18] == 'On')) {
                $active_flg = 1;
            } else {
                $active_flg = 0;
            }

             // Insert new data
            $place = new Place;
            $place->setIncrement(true);
            $place->name  = $row[1];
            $place->name_en  = $row[2];
            $place->tel  = $row[3];
            $place->zip_code  = $row[4];
            $place->prefecture_id  = get_prefecture_id_by_name($row[5]);
            $place->address  = $row[6];
            $place->prefecture_en_id  = get_prefecture_id_by_name_en($row[7]);
            $place->address_en  = $row[8];
            $place->zip_code_default  = $row[9];
            $place->prefecture_id_default  = get_prefecture_id_by_name($row[10]);
            $place->address_default  = $row[11];
            $place->prefecture_default_en_id  = get_prefecture_id_by_name_en($row[12]);
            $place->address_default_en  = $row[13];
            $place->total_place  = $row[14];
            $place->altitude = $row[17];
            $place->active_flg  = $active_flg;
            $place->save();

            $map = new Map();
            $map->place_id  = $place->id;
            $map->latitude  = $row[15];
            $map->longitude  = $row[16];
            $map->save();
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

