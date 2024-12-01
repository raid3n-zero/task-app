<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskMember extends Model
{
    protected $fillable = [
        'projectId',
        'taskId',
        'memberId'
    ];   

    public function member()
    {
        return $this->hasOne(Member::class, 'id');
    }
}
