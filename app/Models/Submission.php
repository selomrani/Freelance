<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['offered_price', 'message', 'task_id', 'offered_by'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
