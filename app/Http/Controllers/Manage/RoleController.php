<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\BaseApp\RoleRequest;
use App\Repositories\BaseApp\PortalRepositories;
use App\Repositories\BaseApp\RoleRepositories;
use App\Model\Role;
use Illuminate\Http\Request;

/**
 * Class RoleController
 * @package App\Http\Controllers\BaseApp
 */
class RoleController extends BaseAdminController
{
    /**
     * @var RoleRepositories
     */
    private $repositories;

    /**
     * RolesController constructor.
     * @param RoleRepositories $repositories
     * @param Request $request
     */
    public function __construct(RoleRepositories $repositories, Request $request)
    {
        // load parent construct
        parent::__construct($request);
        $this->repositories = $repositories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // set rule page
        $this->setRule('r');
        // set page template
        $this->setTemplate('BaseApp.roles.index');
        // load js
        $this->loadJs('theme/admin-template/js/plugins/notifications/sweet_alert.min.js');
        $this->loadJs('js/BaseApp/role/page_role.js');
        //set page title
        $this->setPageHeaderTitle('<span class="text-semibold">Roles</span> - List Role');
        // set breadcumb
        $data = [
            [
                'icon' => 'icon-users4',
                'url' => 'home',
                'title' => 'Dasboard'
            ],
            [
                'title' => 'List Role'
            ]
        ];
        $this->setBreadcumb($data);
        //assign data
        $this->assign('roles', $this->repositories->getListPaginate(10));
        // display page
        return $this->displayPage();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param PortalRepositories $portals
     * @return \Illuminate\Http\Response
     */
    public function create(PortalRepositories $portals)
    {
        // set rule page
        $this->setRule('c');
        // set page template
        $this->setTemplate('BaseApp.roles.add');
        // load js
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/validate.min.js');
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/additional_methods.min.js');
        $this->loadJs('theme/admin-template/js/plugins/forms/selects/select2.min.js');
        $this->loadJs('js/BaseApp/role/page_role.js');
        $this->loadJs('js/BaseApp/role/validation.js');
        //set page title
        $this->setPageHeaderTitle('<span class="text-semibold">Roles</span> - Add Role');
        // set breadcumb
        $data = [
            [
                'icon' => 'icon-users4',
                'url' => 'home',
                'title' => 'Dasboard'
            ],
            [
                'title' => 'List Role',
                'url' => 'base/roles',
            ],
            [
                'title' => 'Add Role',
            ],

        ];
        $this->setBreadcumb($data);
        // assign data
        $this->assign('portals', $portals->getAllSelect());
        // display page
        return $this->displayPage();
    }


    /**
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RoleRequest $request)
    {
        // set rule page
        $this->setRule('c');
        // proses simpan data role ke database
        if($this->repositories->createRole($request->all())){
            // set notificarion success
            flash('Berhasil tambah data role.')->success()->important();
        }else{
            // set notofication error
            flash('Gagal tambah data role.')->error()->important();
        }
        // default page
        return redirect('base/roles/create');
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


    /**
     * Show edit form role from resource
     * @param Role $role
     * @param PortalRepositories $portals
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role, PortalRepositories $portals)
    {
        // set rule page
        $this->setRule('u');
        // set template
        $this->setTemplate('BaseApp.roles.edit');
        // load js
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/validate.min.js');
        $this->loadJs('theme/admin-template/js/plugins/forms/validation/additional_methods.min.js');
        $this->loadJs('js/BaseApp/role/page_role.js');
        $this->loadJs('js/BaseApp/role/validation.js');
        //set page title
        $this->setPageHeaderTitle('<span class="text-semibold">Portals</span> - Edit Portal');
        // set breadcumb
        $data = [
            [
                'icon' => 'icon-users4',
                'url' => 'home',
                'title' => 'Dasboard'
            ],
            [
                'title' => 'List Role',
                'url' => 'base/roles',
            ],
            [
                'title' => 'Edit Role',
            ],

        ];
        $this->setBreadcumb($data);
        // assign data
        $this->assign('portals', $portals->getAllSelect());
        $this->assign('role', $role);
        // display page
        return  $this->displayPage();
    }


    /**
     * Update the specified resource from storage.
     * @param RoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(RoleRequest $request, Role $role)
    {
        // set rule page
        $this->setRule('u');
        // proses update data di database
        if($this->repositories->updateRole($request->all(), $role)){
            // set notificasi success
            flash('Berhasil ubah data role')->success()->important();
        }else{
            // set notificasi error
            flash('Gagal ubah data role')->error()->important();
        }
        // redirect page
        return redirect('base/roles/'.$role->id.'/edit');
    }


    /**
     * Proses hapus role dari database
     * @param Role $role
     * @param RoleRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Role $role, RoleRequest $request)
    {
        // cek request apakah ajax
        if ($request->ajax()){
            // cek rule
            $access = $this->setRule('d');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // proses hapus role dari database
            if($this->repositories->deleteRole($role)){
                // set response
                return response(['message' => 'Berhasil menghapus role.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus role', 'status' => 'failed']);
    }
}
