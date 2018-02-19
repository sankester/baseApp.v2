<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Role extends Model
{
    // set table
    protected $table = 'role';

    // set fillable column
    protected $fillable = ['portal_id','role_nm','role_prioritas','role_desc','default_page'];

    // set relation portal
    public function portal()
    {
        return $this->belongsTo('App\Model\Manage\Portal');
    }

    // set relation to user
    public function user()
    {
        return $this->belongsToMany('App\Model\Manage\UserLogin', 'user_role', 'role_id', 'user_login_id');
    }

    // set relation to permission
    public function permission()
    {
        return $this->belongsToMany('App\Model\Manage\Permission', 'role_permission', 'role_id', 'permission_id');
    }
}
