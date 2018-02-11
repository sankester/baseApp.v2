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
    /**
     * Mengambil list data role dengan limit dan pagination
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListPaginate($limit)
    {
        return Role::paginate($limit);
    }

    // ambil role berdasarkan portal ID
    public function getRoleByPortal($portal_id, $per_page = 10)
    {
        return Role::where('portal_id', $portal_id)->paginate($per_page);
    }

    /**
     * Mengambil semu data role untuk select box
     * @return \Illuminate\Support\Collection : nama role dan id
     */
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
        if(Role::create($request->all())){
            // return true
            return true;
        }
        // default return
        return false;
    }

    /**
     * Proses mengupdate data portal di database
     * @param $params
     * @param Role $role
     * @return bool
     * @internal param $id
     */
    public function updateRole($params, Role $role){
        return $role->update($params);
    }

    /**
     * Proses menghapus  role dari database
     * @param Role $role
     * @return bool|null
     * @throws \Exception
     * @internal param $id
     */
    public function deleteRole(Role $role)
    {
        return  $roleDelete = $role->delete();
    }
}