<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 15/02/2018
 * Time: 10:02
 */

namespace App\Model\Manage;


use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    // set table
    protected $table = 'user_role';

    // set relation to role
    public function role()
    {
        return $this->belongsTo('App\Model\Manage\Role');
    }

    // set relation user
    public function user()
    {
        return $this->belongsTo('App\Model\Manage\UserLogin');
    }
}