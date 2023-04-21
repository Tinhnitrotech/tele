<?php

namespace App\Repositories\Staff\PeopleCheckin;

use App\Models\NumberPeopleCheckin;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class PeopleCheckinRepository
 * @package App\Repositories\Staff\PeopleCheckin
 */
class PeopleCheckinRepository extends BaseRepository implements PeopleCheckinRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return NumberPeopleCheckin::class;
    }

    public function getDetailData() {
        return $this->model->where('place_id', getPlaceID())->first();
    }

    /**
     * @param $params
     * @return bool
     */
    public function createOrUpdatePeopleCheckin($params) {
        DB::beginTransaction();
        try {
            // Replace string to number
            $data = [
                'total_person_checkin' => str_replace(',', '', $params['total_person_checkin']),
                'pregnant' => str_replace(',', '', $params['pregnant']),
                'infants' => str_replace(',', '', $params['infants']),
                'disability' => str_replace(',', '', $params['disability']),
                'caregiver' => str_replace(',', '', $params['caregiver']),
                'medical_device_user' => str_replace(',', '', $params['medical_device_user']),
                'allergic' => str_replace(',', '', $params['allergic']),
                'foreign' => str_replace(',', '', $params['foreign']),
                'other' => str_replace(',', '', $params['other']),
                'place_id' => getPlaceID()
            ];

            $check = $this->model->where('place_id', getPlaceID())->first();
            if($check) {
                $this->updateById($check->id, $data);
            } else {
                $this->model->create($data);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            return false;
        }
    }

}
