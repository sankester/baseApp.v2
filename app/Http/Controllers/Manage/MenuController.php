<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\MenuRequest;
use App\Libs\LogLib\LogRepository;
use App\Libs\LogLib\Model\Log;
use App\Repositories\Manage\MenuRepositories;
use App\Repositories\Manage\PortalRepositories;
use App\Repositories\Manage\UserRepositories;
use Illuminate\Http\Request;

// class name
class MenuController extends BaseAdminController
{
    // set variable
    private $repositories;

    // constructor
    public function __construct(MenuRepositories $repositories, Request $request)
    {
        // load parent construct
        parent::__construct($request);
        $this->repositories = $repositories;
    }

    // tampilkan list role
    public function index(PortalRepositories $portalRepositories)
    {
        // set permission
        $this->setPermission('read-menu');
        // set page template
        $this->setTemplate('manage.menu.index');
        //set page title
        $this->page->setTitle('Manajemen Menu');
        //get and set data
        $listPortal = $portalRepositories->getAll();
        // assign
        $this->assign('portals' , $listPortal);
        // display page
        return $this->displayPage();
    }

    // proses cari
    public function search(Request $request)
    {
        // set permission
        $this->setPermission('read-menu');
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
    public function create(PortalRepositories $portalRepositories, $portalId)
    {
        // set permission
        $this->setPermission('create-menu');
        // set page template
        $this->setTemplate('manage.menu.add');
        // load css
        $this->loadCss('https://fonts.googleapis.com/icon?family=Material+Icons', true);
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('themes/general/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js');
        // set page title
        $this->page->setTitle('Tambah Menu');
        // get data
        $portal = $portalRepositories->getByID($portalId);
        $parentMenu  = $this->repositories->getMenuSelectByPortal($portalId, 0, '');
        $listGroup = $this->repositories->getGroupAvailable($portalId)->toArray();
        $groupOutput  = '';
        foreach ($listGroup as $group) {
            $groupOutput .= '"'.$group['menu_group'].'",';
        }
        // assign data
        $this->assign('portal' , $portal);
        $this->assign('parentMenu' , $parentMenu);
        $this->assign('groupOutput', rtrim($groupOutput,','));
        // load view
        return $this->displayPage();
    }

    // proses simpan
    public function store(MenuRequest $request)
    {
        // set permission
        $this->setPermission('create-menu');
        // proses tambah menu ke database
        if($this->repositories->create($request)){
            // save log
            LogRepository::addLog('insert', 'Menambahkan menu '. $request->menu_nm);
            // set success notification
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil tambah role.']);
        }else{
            // set error notification
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal tambah role.']);
        }
        // redirect page
        return redirect()->route('manage.menu.create', $request->portal_id);
    }

    // tampilkan detail menu by menu
    public function show(UserRepositories  $userRepositories,PortalRepositories $portalRepositories, $portalId)
    {
        // set permission
        $this->setPermission('update-menu');
        // set page template
        $this->setTemplate('manage.menu.detail');
        // load js
        if($userRepositories->cekRolePrioritas($this->repositories->getAuth()->id) == 'true'){
            $this->loadJs('themes/general/Nestable2-master/jquery.nestable.min.js');
        }
        $this->loadJs('js/base/manage/menu/detail.js');
        $this->loadJs('themes/base/assets/vendor_components/sweetalert/sweetalert.min.js');
        // get data
        $portal = $portalRepositories->getByID($portalId);
        // set page title
        $this->page->setTitle('Detail menu '.$portal->portal_nm);
        // get menu
        $listMenu = $this->repositories->getMenuNestable($portal->id, 0);
        // assign data
        $this->assign('portal' , $portal);
        $this->assign('htmlMenu' , $listMenu);
        // load view
        return $this->displayPage();
    }

    // get detail menu
    public function detail(Request $request,$menuID)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // set permission
            $access =  $this->setPermission('read-menu');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // get data
            $menu       = $this->repositories->getByID($menuID)->load('permission');
            // cek data param
            if(! $menu){
                // default response
                return response(['message' => 'Gagal mengambil data menu', 'status' => 'failed']);
            }
            // set html
            $title = 'Detail menu '.$menu->menu_title;
            $stringHtml  = '<ul class="nav nav-tabs customtab" role="tablist">';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Role Data</a></li>';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Permission</a></li>';
            $stringHtml .= '</ul>';
            $stringHtml .= '<div class="tab-content mt-10">';
            $stringHtml .= '<div id="navpills-1" class="tab-pane active pl-20" aria-expanded="false"><div class="row" ><div class="col-md-9">';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Nama</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$menu->menu_title.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Deskripsi</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$menu->menu_desc.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">URL</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$menu->menu_url.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Aktif</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.(($menu->active_st == 'yes') ? 'Iya': 'Tidak').'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Tampilkan</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.(($menu->display_st == 'yes') ? 'Iya': 'Tidak').'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Status</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$menu->menu_st.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Target</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$menu->menu_target.'</label></div></div>';
            $stringHtml .= '</div></div></div>';
            $stringHtml .= '<div id="navpills-2" class="tab-pane pl-20" aria-expanded="true"><div class="row">';
            $stringHtml .= '<div class="box"><div class="box-body"><div class="row">';
            foreach ($menu->permission as $permission) {
                $stringHtml .= '<div class="col-md-4"><div class="media align-items-center">';
                $stringHtml .= '<span class="fa fa-key lead text-info"></span>';
                $stringHtml .= '<div class="media-body"><p><strong>'.$permission->permission_nm.'</strong></p>';
                $stringHtml .= '<p>'.$permission->permission_desc.'</p></div></div></div>';
            }
            $stringHtml .= '</div></div></div>';
            $stringHtml .= '</div></div>';
            // set output
            $outputUser = [
                'title' => $title,
                'html'  => $stringHtml
            ];
            // response
            return response()->json(['data' => $outputUser , 'status' => 'success']);
        }
        // default response
        return response()->json(['message' => 'Gagal mengambil data menu', 'status' => 'failed']);
    }

    // atur urutan menu
    public function sortable(Request $request)
    {
        // set permission
        $this->setPermission('update-menu');
        // cek apakah ajax request
        if ($request->ajax()){
            // get new list
            $listMenu = json_decode($request->list);
            // proses update
            $this->repositories->updateSortable($listMenu);
            // save log
            LogRepository::addLog('update', 'Merubah urutan menu');
        }
    }

    // show edit form
    public function edit($portalId, $menuId, PortalRepositories $portalRepositories)
    {
        // set permission
        $this->setPermission('update-menu');
        // set page template
        $this->setTemplate('manage.menu.edit');
        // load css
        $this->loadCss('https://fonts.googleapis.com/icon?family=Material+Icons', true);
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('themes/general/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js');
        // set page title
        $this->page->setTitle('Edit Menu');
        // get data
        $portal = $portalRepositories->getByID($portalId);
        $menu   = $this->repositories->getByID($menuId);
        $parentMenu  = $this->repositories->getMenuSelectByPortal($portalId, 0, '');
        $listGroup = $this->repositories->getGroupAvailable($portalId)->toArray();
        $groupOutput  = '';
        foreach ($listGroup as $group) {
            $groupOutput .= '"'.$group['menu_group'].'",';
        }
        // assign data
        $this->assign('portal' , $portal);
        $this->assign('menu', $menu);
        $this->assign('parentMenu' , $parentMenu);
        $this->assign('groupOutput', rtrim($groupOutput,','));
        // load view
        return $this->displayPage();
    }

    // proses update manu
    public function update(MenuRequest $request, $menuId)
    {
        // set permission
        $this->setPermission('update-menu');
        // proses edit menu ke database
        if($this->repositories->update($request, $menuId)){
            // save log
            LogRepository::addLog('update', 'Mengubah data menu '.$request->menu_nm);
            // set success notification
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil mengupdate role.']);
        }else{
            // set error notification
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal mengupdate role.']);
        }
        // redirect page
        return redirect()->route('manage.menu.edit', [$request->portal_id, $menuId]);
    }

    // proses ajax hapus
    public function destroy(Request $request, $menuId)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            $access =      $this->setPermission('delete-menu');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // get nama menu
            $namaMenu = $this->repositories->getByID($menuId)->menu_nm;
            // proses hapus menu dari database
            if($this->repositories->delete($menuId)){
                // save log
                LogRepository::addLog('delete', 'Menghapus menu '.$namaMenu);
                // set response
                return response(['message' => 'Berhasil menghapus menu.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus menu', 'status' => 'failed']);
    }

    // getlist menu by menu
    public function getListMenu(Request $request)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // set permission
            $access =  $this->setPermission('read-menu');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // cek data param
            if(!$request->has('portal_id') || empty($request->portal_id)){
                return response()->json(['message' => 'Portal ID harus diisi', 'status' => 'failed']);
            }
            // cek by index
            $index = ($request->has('index')) ? $request->index : 'id';
            // get data
            $listMenu = $this->repositories->getMenuSelectByPortal($request->portal_id, 0, '', $index);
            return response()->json(['list' => $listMenu, 'status' => 'success']);
        }
        // default response
        return response()->json(['message' => 'Gagal mengambil data menu', 'status' => 'failed']);
    }
}
