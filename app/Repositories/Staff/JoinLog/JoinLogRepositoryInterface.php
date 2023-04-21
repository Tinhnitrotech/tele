<?php

namespace App\Repositories\Staff\JoinLog;

interface JoinLogRepositoryInterface
{
    /**
     * @param array $data
     */
    public function createJoinLog($data);
}
