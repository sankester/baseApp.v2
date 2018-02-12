<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 26/08/2017
 * Time: 03:47
 */

namespace App\Repositories\Manage;

use App\Libs\LogLib\LogRepository;
use App\Model\Portal;
use App\Model\Role;

class PermissionRepositoriesBackup
{
    /**
     * Mengambil list menu
     * @param $portalId
     * @param $parentId
     * @param $indent
     * @param array $navViews
     * @return array
     */
    public function getListMenu($portalId, $parentId, $indent, $navViews = array())
    {
        $portal = Portal::findOrFail($portalId);
        $navs = $portal->navs()->where('parent_id', $parentId)->orderBy('nav_no', 'asc')->get();
        if(! empty($navs)){
            foreach ($navs as $key => $nav) {
                $defaultAccess = ['c' =>'0','r' =>'0','u' =>'0','d' =>'0'];
                $nav['nav_title'] = $indent.$nav['nav_title'];
                $childs = $portal->navs->where('parent_id', $nav['id'])->toArray();
                $navViews[] = $nav;
                if(!empty($childs)){
                    $indentChils = $indent."--- ";
                    $navViews = $this->getListMenu($nav['portal_id'],$nav['id'], $indentChils, $navViews);
                }
            }
        }
        return  $navViews ;
    }

    /**
     * Proses update roles
     * @param $roles
     * @param Role $role
     */
    public function update($roles, Role $role)
    {
        // set default role
        $defaultRole = [
            'c' => 0,
            'r' => 0,
            'u' => 0,
            'd' => 0
        ];
        // role to update repositories
        $roleToUpdate = array();
        // loop roles
        foreach ($roles['roles'] as $key => $itemRole) {
            // set nav id to role repositories
            $roleToUpdate[$key]['nav_id']= intval($itemRole['nav_id']);
            // set role repositories
            foreach ($defaultRole as $keyRoleDefault => $item) {
                if(isset($itemRole[$keyRoleDefault])){
                    $roleToUpdate[$key][$keyRoleDefault]= intval($itemRole[$keyRoleDefault]);
                }else{
                    $roleToUpdate[$key][$keyRoleDefault] = $item;
                }
            }
        }
        // update date
        $this->syncRole($role, $roleToUpdate);
        // log
        LogRepository::addLog('Update', 'Ubah data permissions untuk role '. $role->role_nm);
    }

    /**
     * @param Role $role
     * @param array $roles
     */
    public function syncRole(Role $role, array $roles)
    {
        // list role
        $listRoleData = array();
        // list navigation id
        $listNavId = array();
        // get navigation and pust to list  navigation id
        foreach ($roles as $nav) {
            $listNavId[] = $nav['nav_id'];
        }
        // get roles and pust to list role
        foreach ($roles as $key => $roleNav) {
            $listRoleData[$key]['c'] = $roleNav['c'];
            $listRoleData[$key]['r'] = $roleNav['r'];
            $listRoleData[$key]['u'] = $roleNav['u'];
            $listRoleData[$key]['d'] = $roleNav['d'];
        }
        // hapus semua rolee berdasarkan role id
        $role->navs()->detach();
        // looping to insert role
        foreach ($listNavId as $key => $navID) {
            // insert new role
            $role->navs()->attach(
                $navID,
                [
                    'c'=> $listRoleData[$key]['c'],
                    'r'=> $listRoleData[$key]['r'],
                    'u'=> $listRoleData[$key]['u'],
                    'd'=> $listRoleData[$key]['d']
                ]);
        }
    }
}