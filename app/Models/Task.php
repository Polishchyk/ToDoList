<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function children()
    {
        return $this->hasMany(Task::Class,'parent_id')->with('children');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
