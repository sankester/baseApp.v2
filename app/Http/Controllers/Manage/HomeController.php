<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
use App\Repositories\Manage\MenuRepositories;
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
    public function index(MenuRepositories $menuRepositories)
    {
        $this->setPermission('read-home');
        // set page template
        $this->setTemplate('manage.home.index');
        // set page header
        $this->setPageHeaderTitle('<span class="text-semibold">Home</span> - Dashboard');
        $menuRepositories->generateMenu(1);
        // assign
        $role = session()->get('role_active');
        $menu_id = 1;
        $permission = $role->permission()->whereHas('menu', function ($query) use ($menu_id){
            $query->where('menu_id', $menu_id);
        })->get();
//        dd($permission->contains('permission_slug', 'read-home'));
//        dd($permission);
        $user = Auth::user()->with('userData')->first()->toArray();
        $this->assign('user', $permission);
        // display page
        return $this->displayPage();
    }

}
