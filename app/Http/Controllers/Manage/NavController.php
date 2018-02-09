<?php

namespace App\Http\Controllers\BaseApp;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\BaseApp\NavRequest;
use App\Model\Nav;
use App\Repositories\BaseApp\NavRepositories;
use App\Repositories\BaseApp\PortalRepositories;
use Illuminate\Http\Request;

class NavController extends BaseAdminController
{
    /**
     * @var NavRepositories
     */
    private $repositories;

    /**
     * NavController constructor.
     * @param NavRepositories $repositories
     * @param Request $request
     */
    public function __construct(NavRepositories $repositories, Request $request)
    {
        // load parent construct
        parent::__construct($request);
        // initial nav repositories
        $this->repositories = $repositories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PortalRepositories $repositories)
    {
        // set rule page
        $this->setRule('r');
        // set page template
        $this->setTemplate('BaseApp.navs.index');
        //set page title
        $this->setPageHeaderTitle('<span class="text-semibold">Menu</span> - List Portal');
        // set breadcumb
        $data = [
            [
                'icon' => 'icon-list',
                'url' => 'home',
                'title' => 'Dasboard'
            ],
            [
                'title' => 'List Portal'
            ]
        ];
        $this->setBreadcumb($data);
        // assign data
        $this->assign('portals',$repositories->getAll());
        // display page
        return $this->displayPage();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($portal_id)
    {
        // set rule page
        $this->setRule('c');
        // set page template
        $this->setTemplate('BaseApp.navs.add');
        // load style
        $this->loadCss('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        $this->loadCss('theme/admin-template/css/icons/icomoon/styles.css');
        $this->loadCss('plugin/fontawesome-iconpicker/css/fontawesome-iconpicker.min.css');
        // load js
        $this->loadJs('theme/admin-template/js/plugins/forms/selects/select2.min.js');
        $this->loadJs('plugin/fontawesome-iconpicker/js/fontawesome-iconpicker.min.js');
        // load validation js
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/validate.min.js');
        $this->loadJs('theme/admin-template/js/core/libraries/jquery_ui/interactions.min.js');
        $this->loadJs('theme/admin-template/js/core/libraries/jquery_ui/touch.min.js');
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/additional_methods.min.js');
        $this->loadJs('theme/admin-template/js/pages/components_navs.js');
        $this->loadJs('js/BaseApp/nav/validation.js');
        // set portal
        $portal = PortalRepositories::getById($portal_id);
        //set page title
        $this->setPageHeaderTitle('<span class="text-semibold">Menu</span> - Add Menu '.$portal->site_title);
        // set breadcumb
        $data = [
            [
                'icon' => 'icon-list',
                'url' => 'home',
                'title' => 'Dasboard'
            ],
            [
                'url' => 'navs',
                'title' => 'List Portal'
            ],
            [
                'url' =>  'navs/view/'. $portal->id ,
                'title' => 'List Menu'
            ],
            [
                'title' => 'Add Menu '
            ]

        ];
        $this->setBreadcumb($data);
        // assign data
        $this->assign('portal', $portal);
        $this->assign('listParent', NavRepositories::getMenuParent($portal_id));
        // display page
        return $this->displayPage();
    }


    /**
     * Proses tambah navigasi ke database
     * @param NavRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(NavRequest $request)
    {
        // set rule page
        $this->setRule('c');
        // proses tambah data menu ke database
        if($this->repositories->createNav($request->all())){
            // set notification success
            flash('Berhasil tambah data menu.')->success()->important();
        }else{
            // set notification error
            flash('Gagal tambah data manu.')->error()->important();
        }
        // redirect page
        return redirect('base/navs/create/'.$request['portal_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Nav  $nav
     * @return \Illuminate\Http\Response
     */
    public function show(Nav $nav)
    {

    }

    /**
     * Menampilkan list menu berdasarkan portal
     * @param $portal_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($portal_id)
    {
        // set rule page
        $this->setRule('r');
        // set page template
        $this->setTemplate('BaseApp.navs.view');
        // load js
        $this->loadJs('theme/admin-template/js/plugins/notifications/sweet_alert.min.js');
        $this->loadJs('js/BaseApp/nav/page_nav.js');
        //set page title
        $portal = PortalRepositories::getById($portal_id);
        $this->setPageHeaderTitle('<span class="text-semibold">Menu</span> - List Menu '. $portal->site_title);
        // set breadcumb
        $data = [
            [
                'icon' => 'icon-list',
                'url' => 'home',
                'title' => 'Dasboard'
            ],
            [
                'url' => 'navs',
                'title' => 'List Portal'
            ],
            [
                'title' => 'List Menu'
            ]
        ];
        $this->setBreadcumb($data);
        // assign data
        $listMenu = $this->repositories->getMenuByPortal($portal_id, 0, '');
        $this->assign('listMenu',$listMenu);
        $this->assign('portal', $portal);
        // display page
        return $this->displayPage();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $portal_id
     * @param  \App\Model\Nav $nav
     * @return \Illuminate\Http\Response
     */
    public function edit( $portal_id, Nav $nav)
    {
        // set rule page
        $this->setRule('u');
        // set template
        $this->setTemplate('BaseApp.navs.edit');
        // load style
        $this->loadCss('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        $this->loadCss('theme/admin-template/css/icons/icomoon/styles.css');
        $this->loadCss('plugin/fontawesome-iconpicker/css/fontawesome-iconpicker.min.css');
        // load js
        $this->loadJs('theme/admin-template/js/plugins/forms/selects/select2.min.js');
        $this->loadJs('plugin/fontawesome-iconpicker/js/fontawesome-iconpicker.min.js');
        // load validation js
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/validate.min.js');
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/additional_methods.min.js');
        $this->loadJs('js/BaseApp/nav/validation.js');
        // set portal
        $portal = PortalRepositories::getById($portal_id);
        //set page title
        $this->setPageHeaderTitle('<span class="text-semibold">Portals</span> - Edit Portal');
        // set breadcumb
        $data = [
            [
                'icon' => 'icon-list',
                'url' => 'home',
                'title' => 'Dasboard'
            ],
            [
                'url' => 'navs',
                'title' => 'List Portal'
            ],
            [
                'url' =>  'navs/view/'. $portal->id ,
                'title' => 'List Menu'
            ],
            [
                'title' => 'Edit Menu '
            ]
        ];
        $this->setBreadcumb($data);
        // assign data
        $this->assign('portal', $portal);
        $this->assign('listParent', NavRepositories::getMenuParent($portal_id));
        $this->assign('nav', $nav);
        // display page
        return  $this->displayPage();
    }


    /**
     * Proses edit navigasi di database
     * @param NavRequest $request
     * @param Nav $nav
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(NavRequest $request, Nav $nav)
    {
        // set rule page
        $this->setRule('u');
        // porses ubah data menu di database
        if($this->repositories->updateNav($request->all(), $nav)){
            // set notification success
            flash('Berhasil ubah data menu')->success()->important();
        }else{
            // set notification error
            flash('Gagal ubah data menu')->error()->important();
        }
        // redirect page
        return redirect('base/navs/'.$request['portal_id'].'/'.$nav->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Nav $nav
     * @param NavRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nav $nav, NavRequest $request)
    {
        // cek apakah request adalah ajax
        if ($request->ajax()){
            // cek rule
            $access = $this->setRule('d');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // proses hapus menu
            if($this->repositories->deleteNav($nav)){
                // set response
                return response(['message' => 'Berhasil menghapus menu.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus menu', 'status' => 'failed']);
    }
}
