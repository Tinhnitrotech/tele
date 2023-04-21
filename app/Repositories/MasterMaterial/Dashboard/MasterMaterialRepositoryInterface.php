<?php

namespace App\Repositories\MasterMaterial\Dashboard;

interface MasterMaterialRepositoryInterface
{
    public function addMasterMaterial($data);

    public function getListMaterial();

    public function getDetail($id);

    public function updateMaterial($request,$id);

    public function destroy($id);

    public function getMasterMaterial();

}
