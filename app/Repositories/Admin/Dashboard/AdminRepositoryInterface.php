<?php
namespace App\Repositories\Admin\Dashboard;

interface AdminRepositoryInterface
{
    public function updateAdminByEmail($email, array $options);

    public function checkIsEmailAdmin($email);

    public function resetPassword($request, $id);

    public function checkPasswordCurrent($request, $id);

    public function checkFirstLoginByEmail($email);

    public function updateFirstLoginByEmail($email);

    public function getListAdmin($request);

    public function addAdmin($request);

    public function getDetailAdmin($id);

    public function updateAdmin($request, $id);

    public function destroy($id);
}
