<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class UserData extends Model
{
    // set table
    protected $table = 'user_data';

    // set fillable column
    protected $fillable = ['nama_lengkap','tempat_lahir', 'tanggal_lahir','no_telp','jabatan','alamat','foto'];

    // related user login
    public function userLogin(){
        return $this->belongsTo('App\Model\Manage\UserLogin');
    }
}
