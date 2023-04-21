<?php

namespace App\Repositories\Staff\Dashboard;

interface StaffRepositoryInterface
{
    public function updateStaffByEmail($email, array $options);

    public function checkIsStaffEmail($email);

    public function addStaff($request);

    public function destroy($id);

    public function updateStaff($request, $id);

    public function getlistStaff($request);

    public function getDetailStaff($id);

    public function resetPassword($request, $id);

    public function checkPasswordCurrent($request, $id);

    public function updateFirstLogin($email);

    public function checkFirstLoginByEmail($email);
}
