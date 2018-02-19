<?php

namespace App\Http\Controllers\Base;


use App\Http\Controllers\Controller;
use App\Libs\PageLib\PageTrait;
//use App\Repositories\BaseApp\NavRepositories;
use App\Repositories\Manage\MenuRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseAdminController
 * @package App\Http\Controllers\Base
 */
class BaseAdminController extends Controller
{
    use PageTrait;

    /**
     * BaseAdminController constructor.
     * @param Request $request
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request;
        $this->middleware('auth');
        $this->initialPage();
        $this->setDefaultCss();
        $this->setDefaultJs();
        $this->load_theme('base');
        $this->display_current_page();
    }

    /**
     * Set default css to load
     */
    protected function setDefaultCss(){
//        $css = [
//            ['path' => 'theme/admin-template/css/icons/icomoon/styles.css'],
//            ['path' => 'theme/admin-template/css/icons/fontawesome/styles.min.css'],
//            ['path' => 'theme/admin-template/css/all.css'],
//            ['path' => 'theme/admin-template/css/custom.css']
//        ];
//       $this->loadCss($css);
    }

    /**
     * Set Default Js to load
     */
    protected function setDefaultJs()
    {
        $Js= [
            ['path' =>'themes/base/assets/vendor_components/jquery/dist/jquery.min.js'],
            ['path' =>'themes/base/assets/vendor_components/popper/dist/popper.min.js'],
            ['path' =>'themes/base/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js'],
            ['path' =>'themes/base/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.min.js'],
            ['path' =>'themes/base/assets/vendor_components/fastclick/lib/fastclick.js'],
            ['path' =>'themes/base/js/template.js'],
            ['path' =>'themes/base/js/demo.js'],
            ['path' =>'js/base/general/active_menu.js'],
        ];
        $this->loadJs($Js);
    }

    // menampilkan data halaman sekarang
    protected function display_current_page(){
        $currentUrl =  $this->request->segment(1). '/'.$this->request->segment(2). '/'.$this->request->segment(3);
        $menu = MenuRepositories::getMenuByUrl($currentUrl);
        if($menu){
            $this->page->setDefaultTitle($menu->portal->site_title);
            $this->page->setTitle($menu->menu_title);
        }

        isset($menu->portal_id) ?  $this->setMenuActive($menu->id ) : $this->menuActive  ;
        $this->assign('activeMenu', $this->menuActive);
    }


    // set permission
    protected function setPermission($permission)
    {
        // cek result
        if($this->validatePage($this->menuActive) == true) :
            return $this->validateAccess($permission,'base/forbidden/page/');
        else :
            // cek request
            return $this->setErrorAccess('base/forbidden/page/',$this->request, 'maaf, halaman yang anda request tidak tersedia.','404');
        endif;
    }

}
