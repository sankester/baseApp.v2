<?php

namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\BaseApp\PortalRequest;
use App\Model\portal;
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
        // set rule page
//        $this->setRule('r');
        // set page template
        $this->setTemplate('manage.portal.index');
        // load js
        $this->loadJs('theme/admin-template/js/plugins/notifications/sweet_alert.min.js');
        //set page title
        $this->page->setTitle('Portal');
        //assign data
//        $this->assign('portals', $this->repositories->getListPaginate(10));
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
        // set rule page
        $this->setRule('c');
        // set page template
        $this->setTemplate('BaseApp.portals.add');
        // load js
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/validate.min.js');
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/additional_methods.min.js');
        $this->loadJs('js/BaseApp/portal/page_portal.js');
        $this->loadJs('js/BaseApp/portal/validation.js');
        //set page title
        $this->setPageHeaderTitle('<span class="text-semibold">Portals</span> - Add Portals');
        // set breadcumb
        $data = [
            [
                'icon' => 'icon-icon-earth',
                'url' => 'home',
                'title' => 'Dasboard'
            ],
            [
                'title' => 'List Portal',
                'url' => 'base/portals',
            ],
            [
                'title' => 'Add Portal',
            ],

        ];
        $this->setBreadcumb($data);
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
        // set rule page
        $this->setRule('c');
        // proses tambah portal ke database
        if($this->repositories->createPortal($request->all())){
            // set notifikasi sukses
            flash('Berhasil tambah data portal')->success()->important();
        }else{
            // set notifikasi error
            flash('Gagal tambah data portal')->error()->important();
        }
        // redirect page
        return redirect('base/portals/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\portal  $portal
     * @return \Illuminate\Http\Response
     */
    public function show(portal $portal)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\portal  $portal
     * @return \Illuminate\Http\Response
     */
    public function edit(portal $portal)
    {
        // set rule page
        $this->setRule('u');
        // set template
        $this->setTemplate('BaseApp.portals.edit');
        // load js
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/validate.min.js');
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/additional_methods.min.js');
        $this->loadJs('js/BaseApp/portal/page_portal.js');
        $this->loadJs('js/BaseApp/portal/validation.js');
        //set page title
        $this->setPageHeaderTitle('<span class="text-semibold">Portals</span> - Edit Portal');
        // set breadcumb
        $data = [
            [
                'icon' => 'icon-icon-earth',
                'url' => 'home',
                'title' => 'Dasboard'
            ],
            [
                'title' => 'List Portal',
                'url' => 'base/portals',
            ],
            [
                'title' => 'Edit Portal',
            ],

        ];
        $this->setBreadcumb($data);
        // assign data
        $this->assign('portal',$portal);
        // display page
        return  $this->displayPage();
    }


    /**
     * Proses ubah data portal di database
     * @param PortalRequest $request
     * @param portal $portal
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PortalRequest $request, portal $portal)
    {
        // set rule page
        $this->setRule('u');
        // proses update data portal di database
        if($this->repositories->updatePortal($request->all(), $portal)){
            // set notifikasi success
            flash('Berhasil ubah data portal')->success()->important();
        }else{
            // set notifikasi error
            flash('Gagal ubah data portal')->error()->important();
        }
        // redirect page
        return redirect('base/portals/'.$portal->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\portal $portal
     * @param PortalRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(portal $portal, PortalRequest $request)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // cek rule
            $access = $this->setRule('d');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // proses hapus portal dari database
            if($this->repositories->deletePortal($portal)){
                // set response
                return response(['message' => 'Berhasil menghapus portal.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus portal', 'status' => 'failed']);
    }
}
