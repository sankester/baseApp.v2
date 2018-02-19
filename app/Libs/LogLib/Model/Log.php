<?php

namespace App\Libs\LogLib\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'portal_id','user_id', 'action', 'description'
    ];

    public function scopeAdmin($query)
    {
        $query->where('portal_id','=','1');
    }

    public function scopeOperator($query)
    {
        $query->where('portal_id','=','2');
    }

    /**
     * Mengmbil portal berdasarkan user
     * Setiap satu log memiliki satu user
     */
    public function user()
    {
        return $this->belongsTo('App\Model\Manage\UserLogin');
    }
}
