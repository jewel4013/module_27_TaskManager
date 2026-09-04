<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class Group extends Model
{
    
    public function users(){
        return $this->belongsToMany(User::class, 'group_user');
    }
}
