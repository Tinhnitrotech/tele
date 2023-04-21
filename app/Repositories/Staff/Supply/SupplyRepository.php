<?php

namespace App\Repositories\Staff\Supply;

use App\Models\Supply;
use App\Models\SupplyNote;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class SupplyRepository.
 */
class SupplyRepository extends BaseRepository implements SupplyRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Supply::class;
    }

    /**
     * Get Data Not Delete
     */
    public function isNotDelete()
    {
        return $this->where('deleted_at', null);
    }

    /**
     * @param $request Illuminate\Http\Request
     *
     * @return bool
     */
    public function createSupplyAndNotes($request)
    {
        DB::beginTransaction();
        try{
            $this->createSupply($request);
            $this->createSupplyNotes($request);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param $request Illuminate\Http\Request
     */
    public function createSupply($request)
    {
        $placeId = $request->place_id;
        $supply = $request->supply;

        if (!empty($supply) && sizeof($supply) > 0) {
            foreach ($supply as $key => $supply) {
                $data = [
                    'place_id' => $placeId,
                    'm_supply_id' => $supply['m_supply_id'],
                    'number' => $supply['number'] ?? 0
                ];

                $this->model->create($data);
            }
        }

        return false;
    }

    /**
     * @param $request Illuminate\Http\Request
     */
    public function createSupplyNotes($request)
    {
        SupplyNote::updateOrCreate(
            [
                'place_id'   => $request->place_id,
            ],
            [
                'comment'     => $request->comment,
                'note' => $request->note,
            ],
        );
    }

    /**
     * @param int $placeID
     *
     * @return void
     */
    public function getSupplyByPlaceIdWithMaster($placeID, $listMasterMaterial)
    {
        $m_supply_id = $listMasterMaterial->pluck('id')->toArray();
        $supplies = $this->model->where('place_id', $placeID)->whereIn('m_supply_id', $m_supply_id)->get();
        $supplyNotes = SupplyNote::where('place_id', $placeID)->first();
        $supplyNotes = !empty($supplyNotes) ? $supplyNotes->toArray() : [];

        $data = [
            'supplies' => $supplies,
            'supplyNotes' => $supplyNotes,
        ];

        return $data;
    }

    /**
     * @param int $placeID
     *
     * @return void
     */
    public function getSupplyByPlaceId($placeID)
    {

        $supplies = $this->model->where('place_id', $placeID)->get();
        $supplyNotes = SupplyNote::where('place_id', $placeID)->first();
        $supplyNotes = !empty($supplyNotes) ? $supplyNotes->toArray() : [];

        $data = [
            'supplies' => $supplies,
            'supplyNotes' => $supplyNotes,
        ];

        return $data;
    }

    public function setValueListMasterMaterial($listMasterMaterial, $supplies)
    {
        if ($listMasterMaterial->isNotEmpty()) {
            foreach ($listMasterMaterial as $key => $material) {
                if (!empty($supplies[$key])) {
                    $material->number = $supplies[$key]->number;
                }
            }
        }

        return $listMasterMaterial;
    }

    /**
     * @param $request Illuminate\Http\Request
     * @param int $placeId
     *
     * @return bool
     */
    public function updateSupplyByPlaceID($request, $placeId, $supplies)
    {
        DB::beginTransaction();
        try{
            $this->updateAndCreateSupply($request, $placeId, $supplies);
            $this->updateSupplyNotes($request, $placeId);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param $request Illuminate\Http\Request
     * @param int $placeId
     */
    public function updateAndCreateSupply($request, $placeId, $supplies)
    {
        $supply = $request->supply;
        if (!empty($supply) && sizeof($supply) > 0) {
            foreach ($supply as $key => $supply) {
                if (!empty($supplies[($key - 1)]) && $supplies[($key - 1)]->m_supply_id == $supply['m_supply_id']) {
                    $data = [
                        'number' => $supply['number'] ?? 0
                    ];

                    $this->model->where([
                        'place_id' => $placeId,
                        'm_supply_id' => $supply['m_supply_id']
                    ])->update($data);
                } else {
                    $data = [
                        'm_supply_id' => $supply['m_supply_id'],
                        'place_id' => $placeId,
                        'number' => $supply['number'] ?? 0,
                    ];

                    $this->model->create($data);
                }
            }
        }

        return false;
    }

    /**
     * @param $request Illuminate\Http\Request
     * @param int $placeId
     */
    public function updateSupplyNotes($request, $placeId)
    {
        SupplyNote::updateOrCreate(
            [
                'place_id'   => $placeId,
            ],
            [
                'comment'     => $request->comment,
                'note' => $request->note,
            ],
        );

    }
}
