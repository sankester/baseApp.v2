<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\MenuRequest;
use App\Model\Manage\Portal;
use App\Repositories\Manage\MenuRepositories;
use App\Repositories\Manage\PortalRepositories;
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
        // set page template
        $this->setTemplate('manage.menu.add');
        // load css
        $this->loadCss('https://fonts.googleapis.com/icon?family=Mat    erial+Icons', true);
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        // set page title
        $this->page->setTitle('Tambah Menu');
        // get data
        $portal = $portalRepositories->getByID($portalId);
        $parentMenu  = $this->repositories->getMenuSelectByPortal($portalId, 0, '');
        // assign data
        $this->assign('portal' , $portal);
        $this->assign('parentMenu' , $parentMenu);
        // load view
        return $this->displayPage();
    }

    // proses simpan
    public function store(MenuRequest $request)
    {
        // proses tambah menu ke database
        if($this->repositories->create($request)){
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
    public function show(PortalRepositories $portalRepositories, $portalId)
    {
        // set page template
        $this->setTemplate('manage.menu.detail');
        // load js
        $this->loadJs('themes/general/Nestable2-master/jquery.nestable.min.js');
        $this->loadJs('themes/base/assets/vendor_components/sweetalert/sweetalert.min.js');
        $this->loadJs('js/base/manage/menu/detail.js');
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

    public function sortable(Request $request)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // get new list
            $listMenu = json_decode($request->list);
            // proses update
            $this->repositories->updateSortable($listMenu);
        }
    }

    // show edit form
    public function edit($portalId, $menuId, PortalRepositories $portalRepositories)
    {
        // set page template
        $this->setTemplate('manage.menu.edit');
        // load css
        $this->loadCss('https://fonts.googleapis.com/icon?family=Material+Icons', true);
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        // set page title
        $this->page->setTitle('Edit Menu');
        // get data
        $portal = $portalRepositories->getByID($portalId);
        $menu   = $this->repositories->getByID($menuId);
        $parentMenu  = $this->repositories->getMenuSelectByPortal($portalId, 0, '');
        // assign data
        $this->assign('portal' , $portal);
        $this->assign('menu', $menu);
        $this->assign('parentMenu' , $parentMenu);
        // load view
        return $this->displayPage();
    }

    // proses update manu
    public function update(MenuRequest $request, $menuId)
    {
        // proses edit menu ke database
        if($this->repositories->update($request, $menuId)){
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
            // proses hapus menu dari database
            if($this->repositories->delete($menuId)){
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
