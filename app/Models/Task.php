<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['created_by', 'name', 'description', 'status'])]
class Task extends Model
{
    use SoftDeletes;

    public const STATUSES = [
        'created',
        'assigned',
        'progress',
        'hold',
        'completed',
        'cancelled',
    ];

    protected $dates =[
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    

}
