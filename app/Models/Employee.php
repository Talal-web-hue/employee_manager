<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}