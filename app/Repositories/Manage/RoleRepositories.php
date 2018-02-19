<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 20/08/2017
 * Time: 17:30
 */

namespace App\Repositories\Manage;


use App\Model\Manage\Role;
use App\Repositories\Base\BaseRepositories;
use Illuminate\Http\Request;

class RoleRepositories extends BaseRepositories
{
    // set model
    protected $model = 'Manage\\Role';

    // get list dengan paginate
    public function getListPaginate($perPage = 10, ...$params)
    {
        $resultModel = $this->getModel();
        // foreach condition
        if(count($params) > 0){
            foreach ($params as $key => $statement) {
                $condition = $statement[0];
                $operator = (in_array($statement[1], $this->operators) ? $statement[1] : '=');
                $value = (in_array($statement[1], $this->operators) ? $statement[2] : $statement[1]);
                $clause = isset($statement[3]) ? $statement[3] : 'and';
                $relation = isset($statement[4]) ? $statement[4] : '';
                $id = isset($statement[5]) ? $statement[5] : '';
                $resultModel = $this->getData($resultModel, $condition,$operator,$value,$clause,$relation,$id);
            }
        }
        // return paginate
        return  $resultModel->orderBy('role_prioritas')->paginate($perPage);
    }

    // get all role select
    public function getAllSelect()
    {
        $role_data = [];
        $allRole = $this->getModel()->with('portal')->get();
        foreach ($allRole as $role) {
            $role_data[$role->id] =  $role->role_nm.' - '.$role->portal->portal_nm;
        }
        return $role_data;
    }

    // proses tambah role
    public function create(Request $request)
    {
        // set params
        $params = $request->except('permission_id');
        $params['role_prioritas'] = $this->getRolePrioritas($request->portal_id);
        // proses create
        $role = $this->getModel()->create($params);
        if($role){
            // syncrone permission
            if($request->has('permission_id')){
                $role->permission()->sync($request->permission_id);
            }
            // return true
            return true;
        }
        // default return
        return false;
    }

    // proses update
    public function update(Request $request, $roleId){
        // get role
        $role = $this->getByID($roleId);
        if($role->update($request->all())){
            // syncrone permission
            if($request->has('permission_id')){
                $role->permission()->sync($request->permission_id);
            }
            // return true
            return true;
        }
        // default return
        return false;
    }

    // update sortable
    public function updateSortable($params, $roleID)
    {
        // get role
        $role = $this->getByID($roleID);
        return $role->update($params);
    }

    // get role prioritas
    public function getRolePrioritas($portalID)
    {
        $role = $this->getModel()->where('portal_id' , $portalID)->orderBy('role_prioritas', 'desc')->first();
        $number = (is_null($role)) ? 0 : $role->role_prioritas;
        return $number + 1;
    }

}