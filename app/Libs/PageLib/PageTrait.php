<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 15/08/2017
 * Time: 20:29
 */

namespace App\Libs\PageLib;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait PageTrait
{
    /**
     * Objec Page
     * @var
     */
    protected $page;
    /**
     * Data to parsing in view
     * @var
     */
    protected $data;

    /**
     * Tempalate view
     * @var
     */
    protected $template;

    /**
     * Default akses page
     * @var array
     */
    protected $akses_page = [
        'is_access' => true,
        'code_error' => '',
        'nav_id' => '',
        'url' => ''
    ];

    /**
     * Set Tempalte
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Initial page object
     */
    public function initialPage()
    {
        $this->page = new Page();
    }

    /**
     * Add data to parsing in view
     * @param $key
     * @param $value
     */
    protected function assign($key, $value)
    {
        $this->data[$key] = $value;
    }


    /**
     * Display page to view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    protected function displayPage()
    {
//        if ($this->akses_page['is_access'] == false) {
//            return redirect($this->akses_page['url'].$this->akses_page['code_error']. '/' .$this->akses_page['nav_id']);
//        } else {
            $this->assign('page', $this->page);
            return view($this->template, $this->data);
//        }
    }

    /**
     * Tambah Css ke page
     * @param $path
     * @internal param $params
     */
    protected function loadCss($path, $isLink = false)
    {
        $this->page->addCss($path, $isLink);
    }

    /**
     * Tambah Js ke page
     * @param $path
     * @param bool $isLink
     * @internal param $params
     */
    protected function loadJs($path, $isLink = false)
    {
        $this->page->addJs($path, $isLink);
    }

    /**
     * Set Page Headader
     * @param $title
     */
    protected function setPageHeaderTitle($title)
    {
        $this->page->setPageHeader($title);
    }

    /**
     * Set Breadcumb
     * @param $params
     */
    protected function setBreadcumb($params)
    {
        $this->page->getPageBreadcumb()->setBreadcumb($params);
    }

    /**
     * set access property
     * @param $url
     * @param $code
     * @param $nav_id
     */
    protected function setForbiddenAccess($url,$code, $nav_id)
    {
        $this->akses_page['is_access'] = false;
        $this->akses_page['code_error'] = $code;
        $this->akses_page['url'] = $url;
        $this->akses_page['nav_id'] = $nav_id;
    }


    /**
     * cek page is already access
     * @param $nav_id
     * @return mixed
     */
//    protected function validatePage($nav_id)
//    {
//        // cek apakah page tersedia
//        $result = Auth::user()->role->whereHas('navs', function ($query) use ($nav_id) {
//            $query->where('id', '=', $nav_id )->where('active_st', '1');
//        })->get()->toArray();
//        return !empty($result) ? true : false;
//    }

    /**
     * Set Error
     * @param $default_error
     * @param Request $request
     * @param $message
     * @param $code
     * @param null $nav_id
     * @return array
     */
    protected  function setErrorAccess($default_error,Request $request, $message, $code, $nav_id = null){
        if ($request->ajax()) {
            return [
                'access' => 'failed',
                'message' => $message
            ];
        } else {
            $this->setForbiddenAccess($default_error,$code, $nav_id);
        }
    }

    /**
     * Get permissions role page
     * @param $nav_id
     * @return null
     */
//    protected function getRoleAccess($nav_id)
//    {
//        // jika page already exist
//        if (! is_null(Auth::user()->role->navs->where('id', '=', $nav_id)->first())) {
//            return $roles = Auth::user()->role->navs->where('id', '=', $nav_id)->first()->pivot->toArray();
//        }
//        return $roles = null;
//    }


    /**
     * Validate Access Page
     * @param $rule
     * @param $roles
     * @return array
     */
//    protected function validateAccess($rule, $roles, $default_error)
//    {
//        if (($roles[$rule] == '0') || empty($roles[$rule]) ) {
//            // cek request
//            return $this->setErrorAccess($default_error, $this->request, 'maaf, anda tidak  mempunyai akses penuh untuk halaman ini', '403', $this->nav_id);
//        }
//    }

    /**
     * Load Theme
     * @param $theme
     */
    protected function load_theme($theme){
        $this->page->addCss('themes/'.$theme.'/load-style.css');
    }
}