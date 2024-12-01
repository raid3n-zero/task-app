<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Project extends Model
{

    const NOT_STARTED = 0;
    const PENDING = 1;
    const COMPLETED = 2;

    protected $fillable = [
        'name',
        'status',
        'startDate',
        'endDate',
        'slug'
    ];

    public static function createSlug($name)
    {
        return Str::slug($name) . '-' . Str::random(10).time();
    }

    public function task_progress()
    {
        return $this->hasOne(TaskProgress::class, 'projectId');
    }
}
