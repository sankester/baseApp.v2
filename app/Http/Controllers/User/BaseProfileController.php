<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 19/02/2018
 * Time: 13:47
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Base\BaseAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseProfileController extends BaseAdminController
{
    // constructor
    public function __construct(Request $request)
    {
        // parent constructor
        parent::__construct($request);
    }

    public function show()
    {
        // set permission
        $this->setPermission('read-profile');
        // set template
        $this->setTemplate('user/base/profile');
        // get data
        $profile = Auth::user()->load('userData', 'role');
        // assign data
        $this->assign('user', $profile);
        // display page
        return $this->displayPage();
    }

    public function update(Request $request)
    {

    }

}