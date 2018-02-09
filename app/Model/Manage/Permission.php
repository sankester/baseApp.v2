<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Permission extends Model
{
    // set table
    protected $table = 'menu';

    // set fillable column
    protected $fillable = [
        'permission_nm',
    ];

    // set relation menu
    public function menu()
    {
        return $this->belongsToMany('App\Model\Manage\Menu','menu_permission','menu_id','permission_id');
    }
}
