<?php

namespace App\Model\Manage;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserLogin extends Authenticatable
{
    use Notifiable;

    // set table
    protected $table = 'user_login';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'user_data_id','email', 'password','status','experied',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // set relasi ke user data
    public function userData()
    {
        return $this->hasOne('App\Model\Manage\UserData');
    }

    // set relation to role
    public function role()
    {
        return $this->belongsToMany('App\Model\Manage\Role', 'user_role', 'user_login_id', 'role_id')->withPivot('role_id','user_login_id');
    }

    public function logs()
    {
        return $this->hasMany('App\Libs\LogLib\Model\Log');
    }
}
