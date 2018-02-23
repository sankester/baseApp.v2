<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
use App\Repositories\Manage\MenuRepositories;
use App\Repositories\Manage\PermissionRepositories;
use App\Repositories\Manage\RoleRepositories;
use App\Repositories\Manage\UserRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseAdminController
{
    /**
     * Create a new controller instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRepositories $userRepositories, RoleRepositories $roleRepositories, PermissionRepositories $permissionRepositories, MenuRepositories $menuRepositories)
    {
        // set permission
        $this->setPermission('read-home');
        // set page template
        $this->setTemplate('manage.home.index');
        // set page header
        $this->page->setTitle('Home');
        // get data
        $countUser = $userRepositories->getCountUser();
        $countRole = $roleRepositories->getCountWhere(['role_prioritas', '>=', session()->get('role_active')->role_prioritas]);
        $countPermission = $permissionRepositories->getCountPermission();
        $countMenu = $menuRepositories->getCountMenu();
        // assign data
        $this->assign('countUser', $countUser);
        $this->assign('countRole', $countRole);
        $this->assign('countPermission', $countPermission);
        $this->assign('countMenu', $countMenu);
        // display page
        return $this->displayPage();
    }

}
