<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
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
    public function index()
    {
//        $this->setRule('r');
        // set page template
        $this->setTemplate('manage.home.index');
        // set page header
        $this->setPageHeaderTitle('<span class="text-semibold">Home</span> - Dashboard');
        // assign
        $user = Auth::user()->with('userData')->first()->toArray();
        $this->assign('user', $user);
        // display page
        return $this->displayPage();
    }

}
