<?php

namespace App\Http\Controllers\Base;


use App\Http\Controllers\Controller;
use App\Libs\PageLib\PageTrait;
//use App\Repositories\BaseApp\NavRepositories;
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
     * @var array
     */
    protected $role = array();
    /**
     * @var
     */
    protected $portal_id;
    /**
     * @var
     */
    protected $nav_id;
    /**
     * @var Request
     */
    protected $request;

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
//        $this->display_current_page();
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
        ];
        $this->loadJs($Js);
    }

    /**
     * Manampilakna data page
     */
//    protected function display_current_page(){
//        $currentUrl =  $this->request->segment(1). '/'.$this->request->segment(2);
//        $nav = NavRepositories::getNavByUrl($currentUrl);
//        if($nav){
//            $this->page->setTitle($nav->portal->site_title);
//        }
//        isset($nav->portal_id) ?  $this->portal_id = $nav->portal_id: $this->portal_id ;
//        isset($nav->portal_id) ?  $this->nav_id = $nav->id : $this->nav_id  ;
//        $this->assign('nav_id', $this->nav_id);
//    }


    /**
     * Cek autorisasi
     * @param $rule
     * @return array
     */
//    protected function setRule($rule)
//    {
//        // cek result
//        if($this->validatePage($this->nav_id) == true) :
//            $roles = $this->getRoleAccess($this->nav_id);
//            return $this->validateAccess($rule, $roles,'base/forbidden/page/');
//        else :
//            // cek request
//            return $this->setErrorAccess('base/forbidden/page/',$this->request, 'maaf, halaman yang anda request tidak tersedia.','404');
//        endif;
//    }

}
