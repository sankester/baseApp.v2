<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 20/08/2017
 * Time: 17:30
 */

namespace App\Repositories\Manage;


use App\Model\Manage\Role;
use Illuminate\Http\Request;

class RoleRepositories
{
    // get role paginate
    public function getListPaginate($limit)
    {
        return Role::paginate($limit);
    }

    // ambil role berdasarkan portal ID
    public function getRoleByPortal($portal_id, $per_page = 10)
    {
        return Role::where('portal_id', $portal_id)->paginate($per_page);
    }

    public function getRoleById($roleId)
    {
        return Role::findOrFail($roleId);
    }

    // get all role select
    public function getAllSelect()
    {
        $role_data = [];
        $allRole = Role::with('portal')->get();
        foreach ($allRole as $role) {
            $role_data[$role->id] =  $role->role_nm.' - '.$role->portal->portal_nm;
        }
        return $role_data;
    }

    // ambil jumlah role
    public function getCountRole()
    {
        return Role::all()->count();
    }

    // ambil jumlah role berdasarkan portal
    public function getCountRoleByPortal($portal_id)
    {
        return Role::where('portal_id',$portal_id)->count();
    }

    // proses tambah role
    public function createRole(Request $request)
    {
        // proses create
        $role = Role::create($request->except('permission_id'));
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
    public function updateRole(Request $request, $roleId){
        // get role
        $role = $this->getRoleById($roleId);
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

    // proses delete
    public function deleteRole($roleId)
    {
        // get role
        $role = $this->getRoleById($roleId);
        // proses delete
        return $role->delete();
    }
}