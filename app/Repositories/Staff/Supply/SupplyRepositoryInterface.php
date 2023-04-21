<?php

namespace App\Repositories\Staff\Supply;

interface SupplyRepositoryInterface
{
    /**
     * Get Data Not Delete
     */
    public function isNotDelete();

    /**
     * @param $request Illuminate\Http\Request
     */
    public function createSupplyAndNotes($request);

    /**
     * @param $request Illuminate\Http\Request
     */
    public function createSupply($request);

    /**
     * @param $request Illuminate\Http\Request
     */
    public function createSupplyNotes($request);

    /**
     * @param int $placeID
     */
    public function getSupplyByPlaceId($placeID);

    /**
     * @param $placeID
     * @param $listMasterMaterial
     * @return mixed
     */
    public function getSupplyByPlaceIdWithMaster($placeID, $listMasterMaterial);

    /**
     * @param $request Illuminate\Http\Request
     * @param int $placeId
     */
    public function updateSupplyByPlaceID($request, $placeId, $supplies);

    /**
     * @param $request Illuminate\Http\Request
     * @param int $placeId
     */
    public function updateAndCreateSupply($request, $placeId, $supplies);

    /**
     * @param $request Illuminate\Http\Request
     * @param int $placeId
     */
    public function updateSupplyNotes($request, $placeId);
}
