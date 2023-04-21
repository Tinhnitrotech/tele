<?php

namespace App\Repositories\Auth;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\PasswordReset;

/**
 * Class PasswordResetRepository.
 */
class PasswordResetRepository extends BaseRepository implements PasswordResetRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return PasswordReset::class;
    }

    public function getEmailByToken($token)
    {
        return $this->where('token', $token)->first()->email;
    }

    public function deleteEmailByEmail($email)
    {
        $this->where('email', $email)->delete();
    }

    public function createPasswordReset($data)
    {
        return $this->create($data);
    }
}
