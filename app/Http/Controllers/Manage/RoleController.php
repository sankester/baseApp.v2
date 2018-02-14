<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\RoleRequest;
use App\Model\Manage\Role;
use App\Repositories\Manage\MenuRepositories;
use App\Repositories\Manage\PortalRepositories;
use App\Repositories\Manage\RoleRepositories;
use Illuminate\Http\Request;

// class name
class RoleController extends BaseAdminController
{
    // set variable
    private $repositories;

    // constructor
    public function __construct(RoleRepositories $repositories, Request $request)
    {
        // load parent construct
        parent::__construct($request);
        $this->repositories = $repositories;
    }

    // tampilkan list role
    public function index(PortalRepositories $portalRepositories)
    {
        // set page template
        $this->setTemplate('manage.role.index');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/sweetalert/sweetalert.min.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('js/base/manage/role/index.js');
        //set page title
        $this->page->setTitle('Manajemen Role');
        //get and set data
        $listPortal = $portalRepositories->getAll();
        $default_portal = ($this->request->session()->exists('search_role')) ? $this->request->session()->get('search_role') : $listPortal->first()->id;
        $listRoleByPortal = $this->repositories->getRoleByPortal($default_portal);
        // assign
        $this->assign('listPortal' , $listPortal->pluck('portal_nm', 'id'));
        $this->assign('defaultPortal', $default_portal);
        $this->assign('listRole', $listRoleByPortal);
        // display page
        return $this->displayPage();
    }

    // proses cari
    public function search(Request $request)
    {
        // cek input dengan nama search
        if($request->has('search')){
            // validate input
            if($request->get('search') == 'cari'){
                // set session cari
                $request->session()->put('search_role', $request->portal_id);
            }
        }else{
            // remove session cari
            $request->session()->remove('search_role');
        }
        // default redirect
        return redirect()->route('manage.role.index');
    }

    // show form add
    public function create(PortalRepositories $portalRepositories, MenuRepositories $menuRepositories)
    {
        // set page template
        $this->setTemplate('manage.role.add');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('themes/base/assets/vendor_components/jquery-steps-master/build/jquery.steps.js');
        $this->loadJs('js/base/manage/role/crud.js');
        // set page title
        $this->page->setTitle('Tambah Role');
        // get data
        $listPortal   = $portalRepositories->getAll();
        $listMenu   = $menuRepositories->getMenuByPortal($listPortal->first()->id, 0,'');
        $listCollection = collect($listMenu)->pluck('menu_title','menu_url');
        // assign data
        $this->assign('listPortal' , $listPortal->pluck('portal_nm', 'id'));
        $this->assign('listMenu' , $listCollection);
        $this->assign('permissionMenuHtml' , $menuRepositories->getDataMenuByPortalAssignPermission($listPortal->first()->id,0));
        // load view
        return $this->displayPage();
    }

    // proses simpan
    public function store(RoleRequest $request)
    {
        // proses tambah portal ke database
        if($this->repositories->createRole($request)){
            // set success notification
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil tambah role.']);
        }else{
            // set error notification
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal tambah role.']);
        }
        // redirect page
        return redirect()->route('manage.role.create');
    }

    // get list permission ajax
    public function getListPermissionAjax(Request $request, MenuRepositories $menuRepositories)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // cek data param
            if(!$request->has('portal_id') || empty($request->portal_id)){
                return response()->json(['message' => 'Portal ID harus diisi', 'status' => 'failed']);
            }
            // get data
            $listPermission = $menuRepositories->getDataMenuByPortalAssignPermission($request->portal_id, 0);
            // response
            return response()->json(['list' => $listPermission, 'status' => 'success']);
        }
        // default response
        return response()->json(['message' => 'Gagal mengambil data menu', 'status' => 'failed']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit(PortalRepositories $portalRepositories, MenuRepositories $menuRepositories, $roleId)
    {
        // set page template
        $this->setTemplate('manage.role.edit');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('themes/base/assets/vendor_components/jquery-steps-master/build/jquery.steps.js');
        $this->loadJs('js/base/manage/role/crud.js');
        // set page title
        $this->page->setTitle('Edit Role');
        // get data
        $role       = $this->repositories->getRoleById($roleId)->load('permission');
        $listPortal = $portalRepositories->getAll();
        $listMenu   = $menuRepositories->getMenuByPortal($listPortal->first()->id, 0,'');
        $listCollection = collect($listMenu)->pluck('menu_title','menu_url');
        // assign data
        $this->assign('role' ,$role);
        $this->assign('listPortal' , $listPortal->pluck('portal_nm', 'id'));
        $this->assign('listMenu' , $listCollection);
        $this->assign('permissionMenuHtml' , $menuRepositories->getDataMenuByPortalAssignPermission($listPortal->first()->id,0, $role->permission));
        // load view
        return $this->displayPage();
    }


    public function update(RoleRequest $request, $roleId)
    {
        // proses tambah portal ke database
        if($this->repositories->updateRole($request, $roleId)){
            // set success notification
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil ubah role.']);
        }else{
            // set error notification
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal ubah role.']);
        }
        // redirect page
        return redirect()->route('manage.role.edit', $roleId);
    }

    // proses delete role
    public function destroy(Request $request, $roleId)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // proses hapus portal dari database
            if($this->repositories->deleteRole($roleId)){
                // set response
                return response(['message' => 'Berhasil menghapus role.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus role', 'status' => 'failed']);
    }
}
