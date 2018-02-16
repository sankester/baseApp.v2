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
use App\Repositories\Base\BaseRepositories;
use Illuminate\Http\Request;

class PermissionRepositories extends BaseRepositories
{
    // set model
    protected $model = 'Manage\\Permission';

    // get group availible
    public function getGroupAvailible($portalId)
    {
        return $this->getModel()->select('permission_group')->where('portal_id', $portalId)->groupBy('permission_group')->get();
    }

    // proses insert
    public function createPermission($params)
    {
        // proses create
        return $this->getModel()->create($params);
    }

    // update permission
    public function updatePermission($permissionId, Request $request)
    {
        // get permission
        $permission = $this->getByID($permissionId);
        // update
        if($permission->update($request->except('_method', '_token', 'menu_id'))){
            if($request->has('menu_id')){
                $permission->menu()->sync($request->menu_id);
            }
            return true;
        }else{
            return false;
        }

    }
}