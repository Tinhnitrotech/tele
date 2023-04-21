<?php

namespace App\Repositories\Admin\Place;

interface PlaceRepositoryInterface
{
    public function createPlace($data);

    public function createMapPlace($data, $place_id);

    public function getListPlace();

    public function getListPlaceAdmin();

    public function getDetailPlace($id);

    public function editPlace($data, $id);

    public function checkActivePlace($id, $flg_active);

    public function deletePlace($id);

    public function destroySupplyPlace($id);

    public function getStatistics();

    public function getChart($id);

    public function getTotalPersonPlace($totalPlace, $id);

    public function getAllPlaceActiveInfo();

    public function getPlaceDetailInfo($id);

    public function getAllPlaceInfo();

    public function changeFullStatus($id);

    public function changeActiveStatus($id);
}

