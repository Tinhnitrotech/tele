<?php

namespace App\Repositories\MasterMaterial\Dashboard;

use App\Models\MasterMaterial;
use App\Models\Supply;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class MasterMaterialRepository.
 */
class MasterMaterialRepository extends BaseRepository implements MasterMaterialRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return MasterMaterial::class;
    }

    public function addMasterMaterial($request)
    {
        $data = $request->except('_token');
        DB::beginTransaction();
        try {
          $result = $this->create($data);
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function getListMaterial($place = null)
    {
        $listMaterial = $this->where('deleted_at',null)->orderBy('id');
        if(is_null($place)) {
            return $listMaterial->paginate(config('constant.paginate_admin_top'));
        }
        return $listMaterial->get();

    }

    public function getDetail($id)
    {
        return $this->getById($id);
    }

    public function updateMaterial($request,$id)
    {
        $detail = $this->getById($id);
        if ($detail) {
            $data = $request->except('_token');
            return $this->updateById($id,$data);
        }
        return false;
    }

    public function destroy($id)
    {
        $detail = $this->getById($id);
        $supply = Supply::where(['m_supply_id' => $id])->first();
        if ($detail) {
            if($supply) {
                $supply->delete();
            }
            return $this->deleteById($id);

        }
        return false;
    }

    public function getMasterMaterial()
    {
        $result = MasterMaterial::select('id','name','unit')->where('deleted_at',null)->get();
        return $result;
    }
}
