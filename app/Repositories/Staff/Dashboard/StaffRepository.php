<?php

namespace App\Repositories\Staff\Dashboard;

use App\Mail\NewRegisterStaffMail;
use App\Models\StaffLoginHistory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\User;

/**
 * Class UserRepository.
 */
class StaffRepository extends BaseRepository implements StaffRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function updateStaffByEmail($email, array $options)
    {
        $id =  $this->where('email', $email)->first()->id;
        if ($id) {
            return $this->updateById($id, $options);
        }
        return false;
    }

    public function checkIsStaffEmail($email)
    {
        return $this->where('email', $email)->get();
    }

    public function addStaff($request)
    {
        if($request->get('postal_code_1') && $request->get('postal_code_2')) {
            $zipCode = $request->get('postal_code_1') . '-' . $request->get('postal_code_2');
            $data['zip_code'] = $zipCode;
        }
        $password = Str::random(10);
        $subject = trans('staff_management.add_staff_subject');
        $data = $request->except('_token', 'postal_code_1', 'postal_code_2');
        $data['password'] = Hash::make($password);
		$email = $data['email'];
		$checkEmailExist = $this->model->withTrashed()->where('email', $email)->first();
        DB::beginTransaction();
        try {
	        if ($checkEmailExist) {
		        $data['deleted_at'] =  null;
		        $result = $this->model->withTrashed()->where('email', $email)->update($data);
	        } else {
		        $result = $this->model->create($data);
	        }
            Mail::to($data['email'])->send(new NewRegisterStaffMail($subject, $data['name'], $password, $email));
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getDetailStaff($id)
    {
        $detail = $this->getById($id);
        $detail->birthday = Carbon::parse($detail->birthday)->format('Y/m/d');
        $detail->prefecture_name = config('constant.prefectures.' . $detail->prefecture_id);
        $detail->places = User::find($id)->places()->paginate(config('constant.paginate_admin_top'));
        $zipcode = explode("-", $detail->zip_code);
        if ($zipcode) {
            $detail->postal_code_1 = $zipcode[0] ?? '';
            $detail->postal_code_2 = $zipcode[1] ?? '';
        }
        return $detail;
    }

    public function getlistStaff($request)
    {
        $search = $request->input('search');
        $query = User::query();
        if ($search) {
            $query->where('name', 'Like', '%' . $search . '%');
        }
        return $query->where(['deleted_at'=>null])->orderBy('id')->paginate(config('constant.paginate_admin_top'));
    }

    public function updateStaff($request, $id)
    {
        $detail = $this->getById($id);
        if ($detail) {
            $zipCode = $request->get('postal_code_1') . '-' . $request->get('postal_code_2');
            $data = $request->except('_token', 'postal_code_1', 'postal_code_2');
            $data['zip_code'] = $zipCode;
            return $this->updateById($id,$data);
        }
        else return false;
    }

    public function destroy($id)
    {
        $detail = $this->getById($id);
        if ($detail) {
            return $this->deleteById($id);
        }
    }

    public function checkFirstLoginByEmail($email)
    {
        $data = $this->where('email', $email)->first();
        $dataLog = [
            'user_id' => $data->id,
            //To do place_id
            'place_id' => getPlaceID(),
            'login_datetime' => now(),
        ];
        StaffLoginHistory::create($dataLog);
        return $data->first_login;
    }

    public function updateFirstLogin($email)
    {
        $id = $this->where('email', $email)->first()->id;
        $data['first_login'] = now();
        return $this->updateById($id, $data);
    }

    public function checkPasswordCurrent($request, $id)
    {
        $passwordCurrent = $this->getById($id)->password;
        $password = $request->get('password');
        return Hash::check($password, $passwordCurrent);
    }

    public function resetPassword($request, $id)
    {
        $passwordNew = $request->get('password_new');
        $data['password'] = Hash::make($passwordNew);
        DB::beginTransaction();
        try {
            $this->updateById($id, $data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
