<?php

namespace App\Repositories\Staff\Person;

interface PersonRepositoryInterface
{
    /**
     * Get Data Not Delete
     */
    public function isNotDelete();

    /**
     * Create Person By Family ID
     *
     * @param int $familyId
     * @param $request Illuminate\Http\Request
     */
    public function createPersonByFamily($familyId, $request);

    /**
     * Edit Person By Family ID
     *
     * @param int $familyId
     * @param $request Illuminate\Http\Request
     */
    public function editPersonByFamily($familyId, $request);

    /**
     * Get List Person
     *
     * @param $request Illuminate\Http\Request
     * @return Person
     */
    public function getListPerson($request);

    /**
     * @param int $familyId
     */
    public function getPersonByFamilyId($familyId);

    /**
     * @param collection $families
     */
    public function getTotalFamily($families);

    public function getPersonByFamily($placeId, $request, $csv = null);

    public function getPublicPersonByFamily($request, $csv = null);

    public function sortOwner($array, $key);

    public function handlePaginate($items, $request);
}
