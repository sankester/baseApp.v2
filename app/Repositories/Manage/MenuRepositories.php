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
use App\Repositories\Base\BaseRepositories;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class Navs
 * @package App\Repositories\BaseApp
 */
class MenuRepositories extends BaseRepositories
{
    // set model
    protected $model = 'Manage\\Menu';

    // active status menu
    private $isActive = false;

    private $isAccessChild = true;

    // permission role
    private $permissionRole ;

    // is active
    public function isActive()
    {
        return $this->isActive;
    }

    // set is active
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    // is access child menu
    public function isAccessChild()
    {
        return $this->isAccessChild;
    }

    // is access child menu
    public function setAccessChild($isAccessChild)
    {
        $this->isAccessChild = $isAccessChild;
    }

    // ambil data menu berdasarkan portal format object
    public function getDataMenuByPortal($portalID, $parentID, $returnMenu = [], $indent = '')
    {
        $listMenu  = $this->getWhereMultiple(['portal_id',$portalID],['parent_id', $parentID]);
        if (!empty($listMenu)) {
            foreach ($listMenu as $key => $menu) {
                $menu->menu_title = $indent . $menu->menu_title;
                $returnMenu[] = $menu->load('permission');
                $childs = $this->getModel()->where('parent_id' , $menu->id)->get();
                if (!empty($childs)) {
                    $indentChild = $indent.' --- ';
                    $returnMenu = $this->getDataMenuByPortal($portalID, $menu->id, $returnMenu, $indentChild);
                }
            }
        }
        return $returnMenu;
    }

    // get data menu ajax untuk tambah permission role
    public function getDataMenuByPortalAssignPermission($portalID, $parentID, $activePermission = null ,$returnMenu = '', $indent = '')
    {
        // get list menu
        $listMenu  = $this->getWhereMultiple(['portal_id',$portalID],['parent_id', $parentID]);
        if (!empty($listMenu)) {
            foreach ($listMenu as $key => $menu) {
                // set title
                $menu->menu_title = $indent . $menu->menu_title;
                $menu = $menu->load('permission');
                $returnMenu .= '<tr><td><div class="checkbox">';
                // cek apakah ada permission
                if(! $menu->permission->isEmpty() ){
                    $returnMenu .= '<input  type="checkbox" id="all-'.$menu->id.'" class="chk-col-green r-menu checked-all " value="'.$menu->id.'">';
                    $returnMenu .= '<label for="all-'.$menu->id.'"></label>';
                }
                $returnMenu .= '</div></td><td>'.$menu->menu_title.'</td><td><div class="checkbox">';
                foreach ($menu->permission as $access){
                    $checked = '';
                    if(! is_null($activePermission)){
                        foreach ($activePermission as $active) {
                            if($access->id == $active->id){
                                $checked = 'checked';
                            }
                        }
                    }
                    $returnMenu .= '<input name="permission_id[]" type="checkbox" id="p-'.$access->id.'" class="chk-col-green r-'.$menu->id.' r-menu ml-10" value="'.$access->id.'"'.$checked.'>';
                    $returnMenu .= '<label for="p-'.$access->id.'" class="mr-10">'.$access->permission_nm.'</label>';
                }
                $returnMenu .= '</div></td></tr>';
                //get child
                $childs = $this->where('parent_id' , $menu->id);
                if (!empty($childs)) {
                    $indentChild = $indent.' --- ';
                    $returnMenu .= $this->getDataMenuByPortalAssignPermission($portalID, $menu->id, $activePermission , $html = '' , $indentChild);
                }
            }
        }
        return $returnMenu;
    }

    // ambil list menu nastable
    public function getMenuNestable($portalId, $parentId, $viewHtml = '')
    {
        $listMenu  = $this->getModel()->where('portal_id', $portalId)->where('parent_id', $parentId)->orderBy('menu_nomer')->get();
        $viewHtml  .= '<ol class="dd-list">';
        if (!empty($listMenu)) {
            foreach ($listMenu as $key => $menu) {
                $viewHtml  .= ' <li class="dd-item" data-id="'.$menu->id.'" id="'.$menu->id.'">';
                $viewHtml  .= '<div class="dd-handle">';
                $viewHtml  .= '<div class="media">';
                $viewHtml  .= '<div class="media-body">';
                $viewHtml  .= '<p><a class="hover-primary" href="#"><strong>'.$menu->menu_title.'</strong></a>';
                $viewHtml  .= '<time class="float-right">';
                $viewHtml  .= '<a href="#" class="btn btn-success btn-sm detail-menu  mr-5" data-url="'.route('manage.menu.detail',$menu->id).'" data-token="'.csrf_token().'"><i class="mdi mdi-eye"></i></a>';
                $viewHtml  .= '<a href="'.route('manage.menu.edit',[$portalId ,$menu->id]).'" class="btn btn-info btn-sm mr-5"><i class="mdi mdi-pencil"></i></a>';
                $viewHtml  .= '<a href="#" class="btn btn-danger btn-sm delete-menu" delete-id="'.$menu->id.'" delete-url="'. route('manage.menu.destroy', $menu->id ).'" delete-token="'.csrf_token().'"><i class="mdi mdi-delete"></i></a>';
                $viewHtml  .= '</time>';
                $viewHtml  .= '</p>';
                $viewHtml  .= '<p class="subtitle">'.$menu->menu_desc.'. &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; gunakan : '.$menu->active_st.'   &nbsp;&nbsp;&nbsp;|    &nbsp;&nbsp;&nbsp;tampilkan :  '.$menu->display_st.' </p>';
                $viewHtml  .= '</div></div></div>';
                $childs = $this->where('parent_id' , $menu->id)->toArray();
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
            $menu = $this->getByID($data->id);
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
            // replace session
            session()->put('list_menu', $this->generateMenu(0));
        }
    }

    // ambil data menu berdasarkan portal array
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
    public function getMenuSelectByPortal($portalId, $parentId, $indent, $index = 'id', $navViews = array())
    {
        $portal = Portal::findOrFail($portalId);
        $navs = $portal->menu()->where('parent_id', $parentId)->orderBy('menu_nomer', 'asc')->get()->toArray();
        if (!empty($navs)) {
            foreach ($navs as $key => $nav) {
                $childs = $portal->menu()->where('parent_id', $nav['id'])->get()->toArray();
                $navViews[$nav[$index]] = $indent . $nav['menu_title'];;
                if (!empty($childs)) {
                    $indentChilds = $indent . "--- ";
                    $navViews =  $this->getMenuSelectByPortal($nav['portal_id'], $nav['id'], $indentChilds, $index , $navViews);
                }
            }
        }
        return $navViews;
    }

    // generate menu
    public function generateMenu($activeID)
    {
        $html = "";
        // get role from session
        $role = session()->get('role_active')->load('permission');
        // get permission
        foreach ($role->permission as $permission){
            $this->permissionRole[] = $permission->id;
        }
        // get list menu by role
        $listMenu = $role->portal->menu()->where('display_st','yes')->where('parent_id', 0)->orderBy('menu_nomer')->with('permission')->get();
        if($listMenu->isNotEmpty()){
            // set default menu group
            $menuGroup = '';
            foreach ($listMenu as $menu) {
                // continue is not access
                if($this->cekFullAccessMenu($menu->permission) == false){
                    continue;
                }
                // if access
                $selected = ($menu->id == $activeID) ? "class='active'" : "";
                $url = ($menu->menu_st == 'internal') ? url($menu->menu_url) : $menu->menu_url;
                $target = ($menu->menu_target == 'blank') ? '_blank' : '_self';
                $icon = (!empty($menu->menu_icon)) ? strpos('-', $menu->menu_icon).' '. $menu->menu_icon : '';
                $expanded = '';
                // get child
                $str_child_html = $this->getChildMenu($menu->id, $activeID);
                // cek is access child
                if(! $this->isAccessChild()){
                    continue;
                }
                if(!empty($menu->menu_group) && $menu->menu_group != $menuGroup){
                    $html .= ' <li class="header ">'.$menu->menu_group.'</li>';
                    $menuGroup = $menu->menu_group;
                }
                if(!empty($str_child_html)){
                    $selected = 'class="treeview"';
                    $expanded = '<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>';
                }
                if($this->isActive()){
                    $selected = 'class="treeview active menu-open "';
                    $expanded = '<span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>';
                    $this->setIsActive(false);
                }
                // set menu
                $html .= '<li id="mn-'.$menu->id.'"' . $selected . '>';
                $html .= '<a href="' . $url . '" target="' . $target . '" class="menu-item"><i class="' . $icon . ' mr-5"></i><span>' . $menu->menu_title . '</span>'.$expanded.'</a>';
                $html .= $str_child_html;
                $html .= '</li>';
            }

        }
        return $html;
    }

    // generate child menu
    private function getChildMenu($menuID, $activeID)
    {
        $listMenu = $this->getModel()->where('parent_id', $menuID)->orderBy('menu_nomer', 'asc')->with('permission')->get();
        $html = '';
        if ($listMenu->isNotEmpty()) {
            $html .= '<ul class="treeview-menu">';
            $access_id = '';
            foreach ($listMenu as $key => $menu) {
                // continue is not access
                if($this->cekFullAccessMenu($menu->permission) == false){
                    continue;
                }else{
                    $access_id .= $menu->id;
                }
                // cek active menu
                if($menu->id == $activeID){
                    $selected = "class='active'";
                    $this->setIsActive(true);
                }else{
                    $selected = '';
                }
                $html .= '<li id="mn-'.$menu->id.'"'.$selected.'>';
                $url = ($menu->menu_st == 'internal') ? url($menu->menu_url) : $menu->menu_url;
                $target = ($menu->menu_target == 'blank') ? '_blank' : '_self';
                $html .= '<a href="' . $url . '" target="' . $target . '"><span>' . $menu->menu_title . '</span></a>';
                $childs = $this->getModel()->where('parent_id', $menu->id)->orderBy('menu_nomer', 'asc')->get();
                if (!empty($childs)) {
                    $html .= $this->getChildMenu($menu->id, $activeID);
                }
                $html .= "</li>";
            }
            if(empty($access_id)){
                $this->setAccessChild(false);
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

    // static get menu by url
    public static function getMenuByUrl($url)
    {
        $menu = Menu::where('menu_url', '=', $url)->first();
        return $menu;
    }

    // get menu berdasarkan ID static method
    public static function getMenuByID($menuID)
    {
        return Menu::findOrFail($menuID);
    }
    // update
    public function update(Request $request, $id)
    {
        $params =  $request->all();
        if(! $request->has('menu_group')){
            if(intval($request->parent_id) != 0){
                $params['menu_group']  = $this->getByID($request->parent_id)->menu_group;
            }else{
                $params['menu_group'] = '';
            }
        }
        // update
        $menu =  $this->getByID($id)->update($params);
        // cek update
        if($menu){
            // replace session menu
            session()->put('list_menu', $this->generateMenu(0));
            return $menu;
        }else{
            return false;
        }
    }

    // proses simpan
    public function create(Request $request, $column = '')
    {
        // set params
        $params =  $request->all();
        $parent =  intval($params['parent_id']);
        $params['menu_nomer'] = $this->getLastSortNumber($parent);
        if(! $request->has('menu_group')){
            if(intval($request->parent_id) != 0){
                $params['menu_group']  = $this->getByID($request->parent_id)->menu_group;
            }else{
                $params['menu_group'] = '';
            }
        }else{
            $params['menu_group'] = '';
        }
        // proses simpan
        $menu =  $this->getModel()->create($params);
        if($menu){
            session()->put('list_menu',$this->generateMenu(0));
            return $menu;
        }else{
            return false;
        }
    }

    // proses delete
    public function delete($id)
    {
        // delete
        if($this->getByID($id)->delete()){
            session()->put('list_menu',$this->generateMenu(0));
            return true;
        }
        return false;
    }

    // ambil nomor urut terakhir
    public function getLastSortNumber($parent = 0)
    {
        $menu = $this->getModel()->where('parent_id' , $parent)->orderBy('menu_nomer', 'desc')->first();
        $number = (is_null($menu)) ? 0 : $menu->menu_nomer;
        return $number + 1;
    }

    // get group availible
    public function getGroupAvailable($portalID)
    {
        return $this->getModel()->select('menu_group')->where('portal_id', $portalID)->where('parent_id', 0)->groupBy('menu_group')->get();
    }

    // cek full access menu
    private function cekFullAccessMenu($listPermission){
        // cek permission
        foreach ($listPermission as $menuPermission) {
            if(! in_array($menuPermission->id, $this->permissionRole)){
                return false;
            }
        }
        // default retunr
        return true;
    }
}