<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 23/08/2017
 * Time: 19:35
 */

namespace App\Repositories\Manage;

use App\Model\Manage\Menu;
use App\Model\Manage\Portal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class Navs
 * @package App\Repositories\BaseApp
 */
class MenuRepositories
{
    // ambil data menu berdasarkan portal format object
    public function getDataMenuByPortal($portalID, $parentID)
    {
        $listMenu  = Menu::where('portal_id', $portalID)->where('parent_id', $parentID)->get();
        if (!empty($listMenu)) {
            foreach ($listMenu as $key => $menu) {
                $childs = Menu::where('parent_id' , $menu->id)->get();
                if (!empty($childs)) {
                    $childs = $this->getDataMenuByPortal($portalID, $menu->id);
                    $menu->setChildMenu($childs);
                }
            }
        }
        return $listMenu();
    }

    // ambil list menu nastable
    public function getMenuNestable($portalId, $parentId, $viewHtml = '')
    {
        $listMenu  = Menu::where('portal_id', $portalId)->where('parent_id', $parentId)->orderBy('menu_nomer')->get();
        $viewHtml  .= '<ol class="dd-list">';
        if (!empty($listMenu)) {
            foreach ($listMenu as $key => $menu) {
                $viewHtml  .= ' <li class="dd-item" data-id="'.$menu->id.'" id="'.$menu->id.'">';
                $viewHtml  .= '<div class="dd-handle">';
                $viewHtml  .= '<div class="media">';
                $viewHtml  .= '<div class="media-body">';
                $viewHtml  .= '<p><a class="hover-primary" href="#"><strong>'.$menu->menu_title.'</strong></a>';
                $viewHtml  .= '<time class="float-right">';
                $viewHtml  .= '<a href="'.route('manage.menu.edit',[$portalId ,$menu->id]).'" class="btn btn-info btn-sm mr-5"><i class="mdi mdi-pencil"></i></a>';
                $viewHtml  .= '<a href="#" class="btn btn-danger btn-sm delete-menu" delete-id="'.$menu->id.'" delete-url="'. route('manage.menu.destroy', $menu->id ).'" delete-token="'.csrf_token().'"><i class="mdi mdi-delete"></i></a>';
                $viewHtml  .= '</time>';
                $viewHtml  .= '</p>';
                $viewHtml  .= '<p class="subtitle">'.$menu->menu_desc.'. &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; gunakan : '.$menu->active_st.'   &nbsp;&nbsp;&nbsp;|    &nbsp;&nbsp;&nbsp;tampilkan :  '.$menu->display_st.' </p>';
                $viewHtml  .= '</div></div></div>';
                $childs = Menu::where('parent_id' , $menu->id)->get();
                if ( count($childs) != 0) {
                    $viewHtml  .= $this->getMenuNestable($portalId, $menu->id);
                }
                $viewHtml  .= '</li>';
            }
        }
        $viewHtml  .= '</ol>';
        return $viewHtml;
    }

    public function updateSortable($listData, $defaultParent = 0)
    {
        // set start sort
        foreach ($listData as $key => $data) {
            // get manu
            $menu = $this->getMenuById($data->id);
            // set param
            $params = [
                'parent_id' => $defaultParent,
                'menu_nomer' => $key + 1
            ];
            // proses update
            $menu->update($params);
            // cek child
            if(isset($data->children)){
                $this->updateSortable($data->children , $data->id);
            }
        }
    }

    // ambil data menu berdasarkan portal
    public function getMenuByPortal($portalId, $parentId, $indent, $navViews = array())
    {
        $portal = Portal::findOrFail($portalId);
        $navs = $portal->menu()->where('parent_id', $parentId)->orderBy('menu_nomer', 'asc')->get()->toArray();
        if (!empty($navs)) {
            foreach ($navs as $key => $nav) {
                $nav['menu_title'] = $indent . $nav['menu_title'];
                $childs = $portal->menu()->where('parent_id', $nav['id'])->get()->toArray();
                $navViews[] = $nav;
                if (!empty($childs)) {
                    $indentChils = $indent . "--- ";
                    $navViews = $this->getMenuByPortal($nav['portal_id'], $nav['id'], $indentChils, $navViews);
                }
            }
        }
        return $navViews;
    }

    // get menu select box
    public function getMenuSelectByPortal($portalId, $parentId, $indent, $navViews = array())
    {
        $portal = Portal::findOrFail($portalId);
        $navs = $portal->menu()->where('parent_id', $parentId)->orderBy('menu_nomer', 'asc')->get()->toArray();
        if (!empty($navs)) {
            foreach ($navs as $key => $nav) {
                $childs = $portal->menu()->where('parent_id', $nav['id'])->get()->toArray();
                $navViews[$nav['id']] = $indent . $nav['menu_title'];;
                if (!empty($childs)) {
                    $indentChilds = $indent . "--- ";
                    $navViews =  $this->getMenuSelectByPortal($nav['portal_id'], $nav['id'], $indentChilds, $navViews);
                }
            }
        }
        return $navViews;
    }

    // generate menu
    public function generateMenu($portalId, $nav_active)
    {
        $html = "";
        //get nav by parent
        $navs = Auth::user()->role->menu()->where('parent_id', 0)->where('display_st', '1')->orderBy('nav_no', 'asc')->get();
        if (!empty($navs)) {
            foreach ($navs as $key => $nav) {
                if($nav->pivot->c == 0 and $nav->pivot->r == 0 and $nav->pivot->u == 0 and $nav->pivot->d == 0 ){
                   continue;
                }else{
                    $selected = ($nav->id == $nav_active) ? "class='active'" : "";
                    $url = ($nav->nav_st == 'internal') ? url($nav->nav_url) : $nav->nav_url;
                    $target = ($nav->nav_st != 'internal') ? '_blank' : '_self';
                    $icon = (str_contains($nav->nav_icon, 'fa-')) ? 'fa ' . $nav->nav_icon : $nav->nav_icon;
                    $html .= '<li ' . $selected . '>';
                    $html .= '<a href="' . $url . '" target="' . $target . '"><i class="' . $icon . '"></i><span>' . $nav->nav_title . '</span></a>';
                    $str_child_html = $this->getChildNav($nav->id);
                    $html .= !empty($str_child_html) ? $str_child_html : '';
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }

    // generate child menu
    private function getChildMenu($nav_id)
    {
        $navs = Menu::where('parent_id', $nav_id)->orderBy('nav_no', 'asc')->get();
        $html = '';
        if ($navs->count() > 0) {
            $html .= '<ul>';
            foreach ($navs as $key => $nav) {
                $html .= "<li>";
                $url = ($nav->nav_st == 'internal') ? url($nav->nav_url) : $nav->nav_url;
                $target = ($nav->nav_st != 'internal') ? '_blank' : '_self';
                $icon = (str_contains($nav->nav_icon, 'fa-')) ? 'fa ' . $nav->nav_icon : $nav->nav_icon;
                $html .= '<a href="' . $url . '" target="' . $target . '"><i class="' . $icon . '"></i><span>' . $nav->nav_title . '</span></a>';
                $childs = Menu::where('parent_id', $nav->id)->orderBy('nav_no', 'asc')->get();
                if (!empty($childs)) {
                    $html .= $this->getChildMenu($nav->id);
                }
                $html .= "</li>";
            }
            $html .= '</ul>';
        }
        return $html;
    }

    // ambil menu berdasarkan parent
    public static function getMenuParent($portal_id)
    {
        $listParent = array('0' => 'Tidak Ada');
        $listMenu = (new self)->getMenuByPortal($portal_id, 0, '');
        foreach ($listMenu as $key => $item) {
            $listParent[$item['id']] = $item['nav_title'];
        }

        return $listParent;
    }

    // ambil menu berdasarkan url
    public static function getNavByUrl($url)
    {
        $menu = Menu::where('nav_url', '=', $url)->first();
        return $menu;
    }

    // proses simpan
    public function createMenu(Request $request)
    {
        // set params
        $params =  $request->all();
        $parent =  intval($params['parent_id']);
        $params['menu_nomer'] = $this->getLastSortNumber($parent);
        // proses simpan
        $menu =  Menu::create($params);
        if($menu){
            return $menu;
        }else{
            return false;
        }
    }

    // ambil nomor urut terakhir
    public function getLastSortNumber($parent = 0)
    {
        $menu = Menu::where('parent_id' , $parent)->orderBy('menu_nomer', 'desc')->first();
        $number = (is_null($menu)) ? 0 : $menu->menu_nomer;
        return $number + 1;
    }

    // proses update menu
    public function updateMenu(Request $request, $menuId)
    {
        // get menu
        $menu  = $this->getMenuById($menuId);
        if($menu->update($request->all())){
            return true;
        }else{
            return false;
        }
    }

    // hapus menu
    public function deleteMenu($menuId)
    {
        $menu = $this->getMenuById($menuId);
        if($menu->delete()){
               return true;
        }else{
            return false;
        }
    }

    // ambil data menu berdasarkan id
    public static function getMenuById($id)
    {
        return Menu::find($id);
    }

    // ambil jumlah menu
    public function getCountMenu()
    {
        return Menu::all()->count();
    }
}