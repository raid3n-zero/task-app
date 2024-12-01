<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    const NOT_STARTED = 0;
    const PENDING = 1;
    const COMPLETED = 2;

    protected $fillable = [
        'projectId',
        'name',
        'status'
    ];

    public function taskMembers()
    {
        return $this->hasMany(TaskMember::class, 'taskId');
    }

}
