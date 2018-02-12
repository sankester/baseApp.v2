<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Menu extends Model
{
    // set table
    protected $table = 'menu';

    // set custom attribute
    protected $childMenu  = null;

    // set fillable column
    protected $fillable = [
        'portal_id','parent_id',
        'menu_title','menu_desc',
        'menu_url', 'menu_nomer',
        'active_st', 'display_st',
        'menu_st', 'menu_icon',
        'menu_target'
    ];

    // set relation portal
    public function portal()
    {
        return $this->belongsTo('App\Model\Manage\Portal');
    }

    // set relation permission
    public function permission()
    {
        return $this->belongsToMany('App\Model\Manage\Permission', 'menu_permission','menu_id', 'permission_id');
    }

    // get child menu
    public function getChildMenu()
    {
        return $this->childMenu;
    }

    // set child menu
    public function setChildMenu($value)
    {
        $this->childMenu = $value;
    }
}
