<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Portal extends Model
{
    // set table
    protected $table = 'portal';

    // set fillable column
    protected $fillable = ['portal_nm','site_title', 'site_name','site_desc','site_favicon','site_logo','meta_keyword','meta_desc'];

    // set relation role
    public function roles()
    {
        return $this->hasMany('App\Model\Manage\Role');
    }

    // set relational menu
    public function menu()
    {
        return $this->hasMany('App\Model\Manage\Menu');
    }
}
