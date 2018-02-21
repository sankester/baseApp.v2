<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 15/08/2017
 * Time: 20:29
 */

namespace App\Libs\PageLib;


use Illuminate\Http\Request;


trait PageTrait
{
    use AuthPageTrait;

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

    public function setMenuActive($menuID)
    {
        $this->menuActive = $menuID;
        $this->page->menuActive = $menuID;
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
        if ($this->isAccess == false) {
            return redirect( $this->errorUrl . $this->errorCode . '/' .$this->errorMenu)->with('errorMessage', $this->errorMessage);
        } else {
            $this->assign('page', $this->page);
            return view($this->template, $this->data);
        }
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
     * Load Theme
     * @param $theme
     */
    protected function load_theme($theme){
        $this->page->addCss('themes/'.$theme.'/load-style.css');
    }
}