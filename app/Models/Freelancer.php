<?php

namespace App\Models;

class Freelancer extends User
{
    protected $fillable = ['skills', 'portfolio', 'is_available', 'user_id'];

    protected $casts = [
        'skills' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
