<?php

namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\PortalRequest;
use App\Libs\LogLib\LogRepository;
use App\Libs\LogLib\Model\Log;
use App\Repositories\Manage\PortalRepositories;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;

class PortalController extends BaseAdminController
{
    /**
     * @var PortalRepositories
     */
    private $repositories;

    /**
     * PortalController constructor.
     */
    public function __construct(PortalRepositories $repositories,Request $request)
    {
        // load parent construct
        parent::__construct($request);
        // initial portal repositories
        $this->repositories = $repositories;
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // set permission
        $this->setPermission('read-portal');
        // set page template
        $this->setTemplate('manage.portal.index');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/sweetalert/sweetalert.min.js');
        $this->loadJs('js/base/manage/portal/index.js');
        //set page title
        $this->page->setTitle('Manajemen Portal');
        //assign data
        $this->assign('portals', $this->repositories->getListPaginate(10));
        // display page
        return $this->displayPage();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // set permission
        $this->setPermission('create-portal');
        // set page template
        $this->setTemplate('manage.portal.add');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/general/uniform/uniform.min.js');
        //set page title
        $this->page->setTitle('Tambah Portal');
        // load view
        return $this->displayPage();
    }


    /**
     * Proses tambah portal ke database
     */
    public function store(PortalRequest $request)
    {
        // set permission
        $this->setPermission('create-portal');
        // proses tambah portal ke database
        if($this->repositories->create($request)){
            // save log
            LogRepository::addLog('insert', 'Menambahkan portal '.$request->portal_nm);
            // set success notification
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil tambah portal.']);
        }else{
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal tambah portal.']);
        }
        // redirect page
        return redirect()->route('manage.portal.create');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($portalId)
    {
        // set permission
        $this->setPermission('update-portal');
        // set template
        $this->setTemplate('manage.portal.edit');
        // load js
        $this->loadJs('themes/general/uniform/uniform.min.js');
        //set page title
        $this->page->setTitle('Edit Portal');
        // assign data
        $this->assign('portal', $this->repositories->getByID($portalId));
        // display page
        return  $this->displayPage();
    }

    // detail portal
    public function show(Request $request, $portalID)
    {
        // set permission
        $this->setPermission('read-portal');
        // cek apakah ajax request
        if ($request->ajax()) {
            // get data
            $portal = $this->repositories->getByID($portalID);
            if(! $portal){
                // default response
                return response(['message' => 'Gagal mengambil data user', 'status' => 'failed']);
            }
            // set html view
            $title = 'Detail menu '.$portal->portal_nm;
            $stringHtml  = '<ul class="nav nav-tabs customtab" role="tablist">';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Data Portal</a></li>';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Role</a></li>';
            $stringHtml .= '</ul>';
            $stringHtml .= '<div class="tab-content mt-10">';
            $stringHtml .= '<div id="navpills-1" class="tab-pane active pl-20" aria-expanded="false"><div class="row" ><div class="col-md-9">';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Nama</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$portal->portal_nm.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Title</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$portal->site_title.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Deskripsi</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$portal->site_desc.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Jumlah Menu</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$portal->menu->count().'</label></div></div>';
            $stringHtml .= '</div></div></div>';
            $stringHtml .= '<div id="navpills-2" class="tab-pane pl-20" aria-expanded="true"><div class="row">';
            $stringHtml .= '<div class="box"><div class="box-body"><div class="row">';
            foreach ($portal->role as $role) {
                $stringHtml .= '<div class="col-md-4"><div class="media align-items-center">';
                $stringHtml .= '<span class="fa fa-users lead text-info"></span>';
                $stringHtml .= '<div class="media-body"><p><strong>'.$role->role_nm.'</strong></p>';
                $stringHtml .= '<p>'.$role->role_desc.'</p></div></div></div>';
            }
            $stringHtml .= '</div></div></div>';
            $stringHtml .= '</div></div>';
            // set output
            $outputUser = [
                'title' => $title,
                'html'  => $stringHtml
            ];
            // set response
            return response(['data' => $outputUser, 'status' => 'success']);
        }
        // default response
        return response(['message' => 'Gagal mengambil data user', 'status' => 'failed']);

    }

    /**
     * Proses ubah data portal di database
     */
    public function update(PortalRequest $request, $portalId)
    {
        // set permission
        $this->setPermission('update-portal');
        // proses update data portal di database
        if($this->repositories->update($request, $portalId)){
            // save log
            LogRepository::addLog('update', 'Merubah data portal '.$request->portal_nm);
            // set notifikasi success
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil tambah portal.']);
        }else{
            // set notifikasi error
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal tambah portal.']);
        }
        // redirect page
        return redirect()->route('manage.portal.edit', $portalId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($portalId, PortalRequest $request)
    {      // set permission
        $this->setPermission('delete-portal');
        // cek apakah ajax request
        if ($request->ajax()){
            $portalName = $this->repositories->getByID($portalId)->portal_nm;
            // proses hapus portal dari database
            if($this->repositories->delete($portalId)){
                // save log
                LogRepository::addLog('delete','Menghapus portal'.$portalName);
                // set response
                return response(['message' => 'Berhasil menghapus portal.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus portal', 'status' => 'failed']);
    }
}
