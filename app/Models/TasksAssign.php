<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'task_id',
    'assignable_type',
    'assignable_id',
    'assigned_by',
    'assigned_at',    
])]
class TasksAssign extends Model
{
    protected $casts = [
        'assigned_at',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // public function assignable()
    // {
    //     return $this->morphTo();
    // }

    public function assignedBy()
    {
        return $this->belongsTo(User::class , 'assigned_by');
    }

    public function assignableUser()
    {
        return $this->belongsTo(User::class , 'assignable_id')
        ->where('assignable_type', 'user');
    }

    public function assignableGroup()
    {
        return $this->belongsTo(Group::class , 'assignable_id')
        ->where('assignable_type', 'group');
    }
}
