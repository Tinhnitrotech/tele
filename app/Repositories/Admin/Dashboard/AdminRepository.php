<?php

namespace  App\Repositories\Admin\Dashboard;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Admin;

/**
 * Class AdminRepository.
 */
class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Admin::class;
    }

    public function updateAdminByEmail($email, array $options)
    {
        $id =  $this->where('email', $email)->first()->id;
        if ($id) {
            return $this->updateById($id, $options);
        }
        return false;
    }

    public function checkIsEmailAdmin($email)
    {
        return $this->where('email', $email)->first();
    }

    public function checkFirstLoginByEmail($email)
    {
        return $this->where('email', $email)->first()->first_login;
    }

    public function updateFirstLoginByEmail($email)
    {
        $detail = $this->checkIsEmailAdmin($email);
        $data['first_login'] = now();
        return $this->updateById($detail->id, $data);
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

    public function getListAdmin($request)
    {
        $search = $request->input('search');
        $query = Admin::query();
        if ($search) {
            $query->where('name', 'Like', '%' . $search . '%');
        }
        return $query->where(['deleted_at'=>null])->orderBy('id')->paginate(config('constant.paginate_admin_top'));
    }

    /**
     * Register admin
     *
     * @param $request
     * @return false
     */
    public function addAdmin($request)
    {
        $data = $request->except('_token');
        $data['password'] = Hash::make($request->get('password'));
        DB::beginTransaction();
        try {
            $result = $this->model->create($data);
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getDetailAdmin($id)
    {
        $detail = $this->getById($id);
        $detail->birthday = Carbon::parse($detail->birthday)->format('Y/m/d');
        return $detail;
    }

    public function updateAdmin($request, $id)
    {
        $detail = $this->getById($id);
        if ($detail) {
            $data = $request->except('_token', 'password');
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

}
