<?php

namespace App\Model\Manage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Preference extends Model
{
    // set table
    protected $table = 'preference';

    // set fillable column
    protected $fillable = ['pref_group','pref_name', 'pref_value'];

}
