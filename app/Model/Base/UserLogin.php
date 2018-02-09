<?php

namespace App\Model\Base;

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
        return $this->hasOne('App\Model\Base\UserData');
    }
}
