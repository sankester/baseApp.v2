<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\PermissionRequest;
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
        parent::__construct($request);
        $this->repositories = $permissionRepositories;
    }

    // tampilkan list permission
    public function index(PortalRepositories $portalRepositories)
    {
        // set page template
        $this->setTemplate('manage.permission.index');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/sweetalert/sweetalert.min.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        //set page title
        $this->page->setTitle('Manajemen Permission');
        // get search data
        $search = $this->request->session()->get('search_permission');
        // get and set data
        $listPortal = $portalRepositories->getAll();
        $defaultPortal = (isset($search['portal_id'])) ? $search['portal_id'] : $listPortal->first()->id;
        $search['portal_id'] = (isset($search['portal_id'])) ? $search['portal_id'] : $listPortal->first()->id;
        $permissionName = (isset($search['permission_nm'])) ? '%'.$search['permission_nm'].'%' : '%';
        $listPermission = $this->repositories->getListPaginate($defaultPortal,$permissionName);
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

    public function create(PortalRepositories $portalRepositories)
    {
        // set page template
        $this->setTemplate('manage.permission.add');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('themes/general/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js');
        $this->loadJs('js/base/manage/menu/add.js');
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

    // getlist menu by portal
    public function getListMenu(MenuRepositories $menuRepositories, Request $request)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // cek data param
            if(!$request->has('portal_id') || empty($request->portal_id)){
                return response()->json(['message' => 'Portal ID harus diisi', 'status' => 'failed']);
            }
            // get data
            $listMenu = $menuRepositories->getMenuSelectByPortal($request->portal_id, 0, '');
            return response()->json(['list' => $listMenu, 'status' => 'success']);
        }
        // default response
        return response()->json(['message' => 'Gagal mengambil data menu', 'status' => 'failed']);
    }

    public function store(PermissionRequest $request)
    {
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
                // set notifikasi success
                $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil tambah permission.']);
            }else{
                // set notifikasi error
                $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal tambah permission.']);
            }
        }else{
            $crud = explode(',', $request->crud_selected);
            if (count($crud) > 0) {
                foreach ($crud as $x) {
                    // set params
                    $slug         = strtolower($x) . '-' . strtolower($request->resource);
                    $permission_nm = ucwords($x . " " . $request->resource);
                    $description  = "Memperbolkehkan usern untuk " . strtoupper($x) . ' a ' . ucwords($request->resource);
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
                    // set notifikasi success
                    $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil tambah permission.']);
                }
            }
        }
        // default return
        return redirect()->route('manage.permission.create');
    }

    public function show()
    {
        
    }
}
