<?php

namespace App\Repositories\Staff\JoinLog;

use App\Models\JoinLog;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class JoinLogRepository.
 */
class JoinLogRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return JoinLog::class;
    }

    /**
     * @param array $data
     */
    public function createJoinLog($data)
    {
        $this->model->create($data);
    }
}
