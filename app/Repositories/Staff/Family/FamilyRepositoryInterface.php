<?php

namespace App\Repositories\Staff\Family;

interface FamilyRepositoryInterface
{
    /**
     * Get Data Not Delete
     */
    public function isNotDelete();

    /**
     * Create Family
     *
     * @param $request Illuminate\Http\Request
     */
    public function createAddFamily($request);

    /**
     * @param $request Illuminate\Http\Request
     * @param $edit bool
     */
    public function getAttributes($request, $edit = false);

    /**
     * @param $request Illuminate\Http\Request
     */
    public function createAddFamilyAndPerson($request);

    /**
     * @param $request Illuminate\Http\Request
     */
    public function editAddFamilyAndPerson($request, $id);

    /**
     * @param int $id
     */
    public function getFamilyById($id);

    /**
     * @param null | int $id
     */
    public function getDataAttribute($id = null);

    public function getFamilyPersonByPlaceID();

    public function checkPlaceTotal();
}
