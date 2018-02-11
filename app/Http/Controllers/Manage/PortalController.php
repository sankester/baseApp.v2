<?php

namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\PortalRequest;
use App\Repositories\Manage\PortalRepositories;
use Illuminate\Http\Request;

class PortalController extends BaseAdminController
{
    /**
     * @var PortalRepositories
     */
    private $repositories;

    /**
     * PortalController constructor.
     * @param PortalRepositories $repositories
     * @param Request $request
     * @internal param Portals $portals
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param PortalRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PortalRequest $request)
    {
        // proses tambah portal ke database
        if($this->repositories->createPortal($request)){
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil tambah portal.']);
        }else{
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal tambah portal.']);
        }
        // redirect page
        return redirect()->route('manage.portal.create');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($portalId)
    {
        // set template
        $this->setTemplate('manage.portal.edit');
        // load js
        $this->loadJs('themes/general/uniform/uniform.min.js');
        //set page title
        $this->page->setTitle('Edit Portal');
        // assign data
        $this->assign('portal', $this->repositories->getPortalById($portalId));
        // display page
        return  $this->displayPage();
    }


    /**
     * Proses ubah data portal di database
     * @param PortalRequest $request
     * @param $portalId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PortalRequest $request, $portalId)
    {
        // proses update data portal di database
        if($this->repositories->updatePortal($request, $portalId)){
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
     *
     * @param $portalId
     * @param PortalRequest $request
     * @return \Illuminate\Http\Response
     * @internal param \App\Model\portal $portal
     */
    public function destroy($portalId, PortalRequest $request)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // proses hapus portal dari database
            if($this->repositories->deletePortal($portalId)){
                // set response
                return response(['message' => 'Berhasil menghapus portal.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus portal', 'status' => 'failed']);
    }
}
