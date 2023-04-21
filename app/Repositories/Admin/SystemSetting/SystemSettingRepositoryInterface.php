<?php

namespace App\Repositories\Admin\SystemSetting;

interface SystemSettingRepositoryInterface
{
    public function getSetting();

    public function saveSettingSystem($data);

}

