<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Menu extends Model
{
    // set table
    protected $table = 'menu';

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
}
