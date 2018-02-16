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
        // proses create
        $role = $this->getModel()->create($request->except('permission_id'));
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

}