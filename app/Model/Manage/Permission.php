<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Permission extends Model
{
    // set table
    protected $table = 'permission';

    // set fillable column
    protected $fillable = [
        'portal_id',
        'permission_nm',
        'permission_group',
        'permission_slug',
        'permission_desc'
    ];

    // set relation menu
    public function menu()
    {
        return $this->belongsToMany('App\Model\Manage\Menu','menu_permission','permission_id','menu_id')
                    ->withPivot('menu_id');
    }

    // set relation portal
    public function portal(){
        return $this->belongsTo('App\Model\Manage\Portal');
    }

    // set relation role
    public function role()
    {
        return $this->belongsToMany('App\Model\Manage\Role', 'role_permission', 'permission_id', '');
    }
}
