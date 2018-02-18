<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Base\BaseAdminController;
use App\Repositories\Manage\MenuRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForbiddenAccess extends BaseAdminController
{
    public function __construct(Request $request)
    {
        // load parent construct
        parent::__construct($request);
    }

    // forbidden page
    public function page($code, $menuID = '') {
        // set page template
        $this->setTemplate('errors.base.error_page');
        // get navigation info
        if (!empty($menuID)) {
            $menu = MenuRepositories::getMenuByID($menuID);
        }
        switch ($code) {
            case 403 :
                $data = [
                    'code' => $code,
                    'message' => '<b>Maaf,</b> anda tidak mempunyai akses penuh ke halaman <b>'.Str::lower($menu->menu_title).'</b>.'
                ];
                break;
            case 404:
                $data = [
                    'code' => $code,
                    'message' => '<b>Maaf,</b> Halaman yang anda request tidak tersedia'
                ];
                break;
        }
        $this->assign("data", $data);
        // output
        return  $this->displayPage();
    }
}
