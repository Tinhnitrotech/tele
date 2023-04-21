<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function ajaxSearchFamily($data);

    public function updateFamilyLeave($familyId);

    public function updateJoinLog($familyId, $status, $place_id);

    public function checkInRemoteFamily($data);
}
