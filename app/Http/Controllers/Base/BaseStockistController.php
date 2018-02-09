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

class BaseStockistController extends Controller
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
        $this->middleware('isPortal:Stockis');
        $this->initialPage();
        $this->load_theme('stockis-template');
        $this->setDefaultCss();
        $this->setDefaultJs();
        $this->display_current_page();
    }

    /**
     * Set default css to load
     */
    protected function setDefaultCss()
    {
        $css = [
            ['path' => 'http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css', 'type' => 'link'],
            ['path' => 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons', 'type' => 'link'],
            ['path' => 'https://fonts.googleapis.com/icon?family=Material+Icons', 'type' => 'link'],
        ];
        $this->loadCss($css);
    }

    /**
     * Set Default Js to load
     */
    protected function setDefaultJs()
    {
        $Js = [
            ['path' => 'theme/stockis-template/js/jquery-3.2.1.min.js'],
            ['path' => 'theme/stockis-template/js/bootstrap.min.js'],
            ['path' => 'theme/stockis-template/js/material.min.js'],
            ['path' => 'theme/stockis-template/js/perfect-scrollbar.jquery.min.js'],
            ['path' => 'https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js', 'type' => 'link'],
            ['path' => 'theme/stockis-template/js/arrive.min.js'],
            ['path' => 'theme/stockis-template/js/bootstrap-notify.js'],
            ['path' => 'theme/stockis-template/js/sweetalert2.js'],
            ['path' => 'theme/stockis-template/js/material-dashboard.js?v=1.2.1:6624'],
//            ['path' => 'theme/stockis-template/js/demo.js'],
        ];
        $this->loadJs($Js);
    }

    /**
     * Manampilakna data page
     */
    protected function display_current_page()
    {
        $path = $this->request->path();
        $path = explode('/', $path);
        $nav = NavRepositories::getNavByUrl($path[0].'/'.$path[1]);
        if ($nav) {
            $this->page->setDefaultTitle($nav->portal->site_title);
        }
        isset($nav->portal_id) ? $this->portal_id = $nav->portal_id : $this->portal_id;
        isset($nav->portal_id) ? $this->nav_id = $nav->id : $this->nav_id;
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
        if ($this->validatePage($this->nav_id) == true) :
            $roles = $this->getRoleAccess($this->nav_id);
            return $this->validateAccess($rule, $roles, 'stockis/forbidden/page/');
        else :
            // cek request
            return $this->setErrorAccess('stockis/forbidden/page/', $this->request, 'maaf, halaman yang anda request tidak tersedia.', '404');
        endif;
    }

    protected function validatePage($nav_id)
    {
        // cek apakah page tersedia
        $result = Auth::user()->role->whereHas('navs', function ($query) use ($nav_id) {
            $query->where('id', '=', $nav_id)->where('active_st', '1');
        })->get()->toArray();
        return !empty($result) && $this->portal_id == 3 ? true : false;
    }
}