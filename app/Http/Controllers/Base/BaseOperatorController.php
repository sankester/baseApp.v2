<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 20/09/2017
 * Time: 09:57
 */

namespace App\Http\Controllers\Base;


use App\Http\Controllers\Controller;
use App\Libs\PageLib\PageTrait;
use App\Repositories\BaseApp\NavRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseOperatorController extends Controller
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
        $this->middleware('isPortal:Operator');
        $this->initialPage();
        $this->setDefaultCss();
        $this->setDefaultJs();
        $this->display_current_page();
    }

    /**
     * Set default css to load
     */
    protected function setDefaultCss(){
        $css = [
            'theme/admin-template/css/icons/icomoon/styles.css',
            'theme/admin-template/css/icons/fontawesome/styles.min.css',
            'theme/admin-template/css/all.css',
            'theme/admin-template/css/custom.css'
        ];
        $this->loadCss($css);
    }

    /**
     * Set Default Js to load
     */
    protected function setDefaultJs()
    {
        $Js= [
            'theme/admin-template/js/plugins/loaders/pace.min.js',
            'theme/admin-template/js/core/libraries/jquery.min.js',
            'theme/admin-template/js/core/libraries/bootstrap.min.js',
            'theme/admin-template/js/plugins/loaders/blockui.min.js',
            'theme/admin-template/js/core/app.js'];
        $this->loadJs($Js);
    }

    /**
     * Manampilakna data page
     */
    protected function display_current_page(){
        $currentUrl =  $this->request->segment(1). '/'.$this->request->segment(2);
        $nav = NavRepositories::getNavByUrl($currentUrl);
        if($nav){
            $this->page->setTitle($nav->portal->site_title);
        }
        isset($nav->portal_id) ?  $this->portal_id = $nav->portal_id: $this->portal_id ;
        isset($nav->portal_id) ?  $this->nav_id = $nav->id : $this->nav_id  ;
        $this->assign('nav_id', $this->nav_id);
    }


    /**
     * Cek autorisasi
     * @param $rule
     * @return array
     */
    protected function setRule($rule)
    {
        // cek result
        if($this->validatePage($this->nav_id) == true) :
            $roles = $this->getRoleAccess($this->nav_id);
            return $this->validateAccess($rule, $roles, 'base/forbidden/page/');
        else :
            // cek request
            return $this->setErrorAccess('base/forbidden/page/',$this->request, 'maaf, halaman yang anda request tidak tersedia.','404');
        endif;
    }

    protected function validatePage($nav_id)
    {
        // cek apakah page tersedia
        $result = Auth::user()->role->whereHas('navs', function ($query) use ($nav_id) {
            $query->where('id', '=', $nav_id )->where('active_st', '1');
        })->get()->toArray();
        return !empty($result) && $this->portal_id == 2 ? true : false;
    }
}