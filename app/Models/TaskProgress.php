<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskProgress extends Model
{
    
    const NOT_PINNED_ON_DASHBOARD = 0;
    const PINNED_ON_DASHBOARD = 1;
    const INITIAL_PROJECT_PRECENT = 0;

    protected $fillable = [
        'projectId',
        'pinned_on_dashboard',
        'progress'
    ];

}
