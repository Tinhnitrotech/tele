<?php

namespace App\Repositories\Auth;

interface PasswordResetRepositoryInterface
{
    public function getEmailByToken($token);

    public function deleteEmailByEmail($email);

    public function createPasswordReset($data);

}