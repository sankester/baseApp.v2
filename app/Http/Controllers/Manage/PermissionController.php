<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\PermissionRequest;
use App\Libs\LogLib\LogRepository;
use App\Model\Manage\Menu;
use App\Repositories\Manage\MenuRepositories;
use App\Repositories\Manage\PermissionRepositories;
use App\Repositories\Manage\PortalRepositories;
use Illuminate\Http\Request;

class PermissionController extends BaseAdminController
{
    // permission repositories
    private $repositories;

    public function __construct( PermissionRepositories $permissionRepositories, Request $request)
    {
        // parent controller
        parent::__construct($request);
        $this->repositories = $permissionRepositories;
    }

    // tampilkan list permission
    public function index(PortalRepositories $portalRepositories)
    {
        // set permission
        $this->setPermission('read-permission');
        // set page template
        $this->setTemplate('manage.permission.index');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/sweetalert/sweetalert.min.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('js/base/manage/permission/index.js');
        //set page title
        $this->page->setTitle('Manajemen Permission');
        // get search data
        $search = $this->request->session()->get('search_permission');
        // get and set data
        $listPortal = $portalRepositories->getAll();
        $defaultPortal = (isset($search['portal_id'])) ? $search['portal_id'] : $listPortal->first()->id;
        $search['portal_id'] = (isset($search['portal_id'])) ? $search['portal_id'] : $listPortal->first()->id;
        $permissionName = (isset($search['permission_nm'])) ? '%'.$search['permission_nm'].'%' : '%';
        $listPermission = $this->repositories->getListPaginate(10, ['portal_id', $defaultPortal], ['permission_nm','like',$permissionName]);
        // assign
        $this->assign('listPortal' , $listPortal->pluck('portal_nm', 'id'));
        $this->assign('search', $search);
        $this->assign('listPermission', $listPermission);
        // display page
        return $this->displayPage();
    }

    // proses cari
    public function search(Request $request)
    {
        // set permission
        $this->setPermission('read-permission');
        // cek input dengan nama search
        if($request->has('search')){
            // validate input
            if($request->get('search') == 'cari'){
                // set data
                $data = [
                    'portal_id' => $request->portal_id,
                    'permission_nm' => $request->permission_nm,
                ];
                // set session cari
                $request->session()->put('search_permission', $data);
            }
        }else{
            // remove session cari
            $request->session()->remove('search_permission');
        }
        // default redirect
        return redirect()->route('manage.permission.index');
    }

    // show form create
    public function create(PortalRepositories $portalRepositories)
    {
        // set permission
        $this->setPermission('create-permission');
        // set page template
        $this->setTemplate('manage.permission.add');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('themes/general/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js');
        $this->loadJs('js/base/manage/permission/create.js');
        $this->loadJs('js/app.js');
        //set page title
        $this->page->setTitle('Tambah Permission');
        // get data
        $listPortal = $portalRepositories->getAll();
        $listGroup = $this->repositories->getGroupAvailible( $listPortal->first()->id)->toArray();
        $groupOutput  = '';
        foreach ($listGroup as $group) {
            $groupOutput .= '"'.$group['permission_group'].'",';
        }
        // assign data
        $this->assign('portals', $listPortal->pluck('portal_nm', 'id'));
        $this->assign('defaultPortalSelected', $listPortal->first()->id);
        $this->assign('groupOutput', rtrim($groupOutput,','));
        // display page
        return $this->displayPage();
    }

    // proses insert
    public function store(PermissionRequest $request)
    {
        // set permission
        $this->setPermission('create-permission');
        // cek permission type
        if($request->permission_type == 'basic'){
            $permission = $this->repositories->createPermission($request->all());
            if($permission){
                // cek menu
                if($request->has('menu_id')){
                    // attach menu
                    foreach ($request->menu_id as $menu) {
                        $permission->menu()->attach($menu);
                    }
                }
                // save log
                LogRepository::addLog('insert', 'Menambahkan basic permission '.$request->permission_nm);
                // set notifikasi success
               $this->setNotification('Berhasil menambah permission')->success();
            }else{
                // set notifikasi error
                $this->setNotification('Gagal menambah permission')->danger();
            }
        }else{
            $crud = explode(',', $request->crud_selected);
            if (count($crud) > 0) {
                foreach ($crud as $x) {
                    // set params
                    $slug         = strtolower($x) . '-' . strtolower($request->resource);
                    $permission_nm = ucwords($x . " " . $request->resource);
                    $description  = "Memperbolehkan user untuk " . strtoupper($x) . ' ' . ucwords($request->resource);
                    $params = [
                        'portal_id' => $request->portal_id,
                        'permission_nm' => $permission_nm,
                        'permission_slug' => $slug,
                        'permission_group' => $request->permission_group,
                        'permission_desc' => $description
                    ];
                    // proses create
                    $permission = $this->repositories->createPermission($params);
                    // cek menu
                    if($request->has('menu_id')){
                        // attach menu
                        foreach ($request->menu_id as $menu) {
                            $permission->menu()->attach($menu);
                        }
                    }
                    // save log
                    LogRepository::addLog('insert','Menambahkan resource permission '.$request->resource);
                    // set notifikasi success
                    $this->setNotification('Berhasil tambah permission')->success();
                }
            }
        }
        // default return
        return redirect()->route('manage.permission.create');
    }

    public function show()
    {
        
    }

    // show form edit
    public function edit(MenuRepositories $menuRepositories, $permissionId)
    {
        // set permission
        $this->setPermission('update-permission');
        // set page template
        $this->setTemplate('manage.permission.edit');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('themes/general/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js');
        $this->loadJs('js/base/manage/permission/edit.js');
        //set page title
        $this->page->setTitle('Edit Permission');
        // cek data
        if(! $this->repositories->isExist($permissionId)){
            // set notification
            $this->setNotification('Permission tidak ditemukan.')->danger();
            // return
            return redirect()->route('manage.permission.index');
        }
        // get data
        $permission = $this->repositories->getByID($permissionId);
        $listGroup = $this->repositories->getGroupAvailible( $permission->portal_id)->toArray();
        $groupOutput  = '';
        foreach ($listGroup as $group) {
            $groupOutput .= '"'.$group['permission_group'].'",';
        }
        if(! empty($permission->menu()->get()->toArray())){
            // get menu
            $lisMenu = $menuRepositories->getMenuSelectByPortal($permission->portal_id, '0','');
            $listSelectedMenu = $permission->menu()->get()->all();
            $selectedMenu     = [];
            foreach ($listSelectedMenu as $menu){
                array_push($selectedMenu, $menu->id);
            }
            // assign menu
            $this->assign('listMenu', $lisMenu);
            $this->assign('selectedMenu', $selectedMenu);
        }
        // assign data
        $this->assign('permission', $permission);
        $this->assign('groupOutput', rtrim($groupOutput,','));
        // display page
        return $this->displayPage();
    }

    // proses update
    public function update(PermissionRequest $request, $permissionId)
    {
        // set permission
        $this->setPermission('update-permission');
        // cek data
        if(! $this->repositories->isExist($permissionId)){
            // set notification
            $this->setNotification('Permission tidak ditemukan.')->danger();
            // return
            return redirect()->route('manage.permission.index');
        }
        // proses update
        if($this->repositories->updatePermission($permissionId,$request)){
            // save log
            LogRepository::addLog('update', 'Mengubah data permission '.$request->permission_nm);
            // set notifikasi success
            $this->setNotification('Berhasil mengubah data permission')->success();
        }else{
            // set notifikasi error
            $this->setNotification('Gagal mengubah data permission')->danger();
        }
        // redirect
        return redirect()->route('manage.permission.edit', $permissionId);
    }

    // proses hapus
    public function destroy($permissionId, PermissionRequest $request)
    {

        // cek apakah ajax request
        if ($request->ajax()){
            // set permission
            $access =   $this->setPermission('delete-permission');
            // cek akses
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // cek data
            if(! $this->repositories->isExist($permissionId)){
                return response(['message' => 'Permission tidak ditemukan.', 'status' => 'failed']);
            }
            // get nama permission
            $permissionName = $this->repositories->getByID($permissionId)->permission_nm;
            // proses hapus permission dari database
            if($this->repositories->delete($permissionId)){
                // save log
                LogRepository::addLog('delete', 'Menghapus permission '.$permissionName);
                // set response
                return response(['message' => 'Berhasil menghapus portal.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus portal', 'status' => 'failed']);
    }
}
