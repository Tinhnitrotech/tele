<?php

namespace App\Repositories\User;

use App\Models\Family;
use App\Models\JoinLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\User;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function ajaxSearchFamily($data)
    {
        if(isset($data['is_remote'])) {
            $family = Family::with('person')
                ->where(['family_code' => $data['family_code']])
                ->first();
        } else {
            $family = Family::with('person')
                ->where(['family_code' => $data['family_code']])
                ->where(['place_id' => getPlaceID()])
                ->whereNotNull('place_id')
                ->where(function($query){
                    $query->where('out_date', null)->orWhere('out_date', '>', now());
                })->first();
        }

        if ($family && Hash::check($data['password'], $family->password)) {
            $family->createdDate = changeFormatDateTime($family->created_at, App::getLocale());
            $family->person->map(function ($data) {
                $data->createdDate = changeFormatDateTime($data->created_at, App::getLocale());
                $data->option = ($data->option  == 0 ) ? '' : trans('common.person_requiring_option')[$data->option];
            });
            return $family;
        }
        return $family = null;
    }

    /**
     * @param $familyId
     * @return bool
     */
    public function updateFamilyLeave($familyId)
    {
        $data = array(
            'out_date' => now(),
            'place_id' => null,
        );
        $family = Family::where('id', $familyId)->first();
        DB::beginTransaction();
        try {
            $this->updateJoinLog($family, config('constant.status_checkout'), null);
            $family->update($data);
            DB::commit();
            return  true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function updateJoinLog($family, $status, $place_id)
    {
        $place_id = empty($place_id) ? $family->place_id : $place_id;
        $data['status'] = $status;
        $data['access_datetime'] = now();
        $data['place_id'] = $place_id;
        $data['prefecture_id'] = $family->prefecture_id;
        $data['family_id'] = $family->id;
        return JoinLog::create($data);
    }

    /**
     * Checkin Family Remote
     *
     * @param $data
     * @param $family_id
     * @return bool
     */
    public function checkInRemoteFamily($data)
    {
        $dataUpdate = array(
            'join_date' => now(),
            'out_date' => null,
            'place_id' => getPlaceID(),
        );
        $family = Family::findOrFail($data['family_id']);
        if ($family->place_id == getPlaceID()) {
            return config('constant.check_in_again');
        }
        DB::beginTransaction();
        try {
            if ($family->place_id) {
                $this->updateJoinLog($family, config('constant.status_checkout'), $family->place_id);
            }
            $this->updateJoinLog($family, config('constant.status_checkin'), getPlaceID());
            $family->update($dataUpdate);
            DB::commit();
            return config('constant.check_in');
        } catch (\Exception $e) {
            DB::rollBack();
            return config('constant.check_in_fail');
        }
    }

}
