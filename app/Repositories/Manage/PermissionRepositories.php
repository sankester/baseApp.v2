<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 26/08/2017
 * Time: 03:47
 */

namespace App\Repositories\Manage;

use App\Libs\LogLib\LogRepository;
use App\Model\Manage\Permission;
use App\Model\Portal;
use App\Model\Role;
use Illuminate\Http\Request;

class PermissionRepositories
{
    // grt list permission
    public function getListPaginate($portalId, $permissionName, $perPage = 10)
    {
        return Permission::where('portal_id', $portalId)
               ->where('permission_nm', 'like',$permissionName)
               ->paginate($perPage);
    }

    // proses insert
    public function createPermission($params)
    {
        // proses create
        return Permission::create($params);
    }

    // get group availible
    public function getGroupAvailible($portalId)
    {
        return Permission::select('permission_group')->where('portal_id', $portalId)->groupBy('permission_group')->get();
    }
}