<?php

namespace App\Models;

class Client extends User
{
    protected $fillable = ['user_id', 'company', 'description'];

    public function infos()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
