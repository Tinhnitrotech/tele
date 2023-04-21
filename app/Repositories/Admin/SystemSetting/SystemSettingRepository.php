<?php

namespace  App\Repositories\Admin\SystemSetting;


use App\Models\SystemSetting;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class PlaceRepository.
 */
class SystemSettingRepository extends BaseRepository implements SystemSettingRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return SystemSetting::class;
    }


    /**
     * Get setting system
     *
     *
     * @return mixed
     */
    public function getSetting()
    {
        $setting = SystemSetting::first();
        return $setting;
    }


    /**
     * Save setting system
     *
     * @param $data
     * @return bool
     */
    public function saveSettingSystem($data)
    {
        DB::beginTransaction();
        try {
            $setting = SystemSetting::first();
            if (!$setting) {
                SystemSetting::create($data);
                DB::commit();
                return true;
            }
            SystemSetting::where('id',$setting->id)->update($data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

}
