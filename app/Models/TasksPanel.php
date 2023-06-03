<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasksPanel extends Model
{
    use HasFactory;

    protected $table = 'tasks_panels';

    protected $fillable = [
        'name',
        'description',
        'background_color'
    ];


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_in_tasks_panels', 'tasks_panel_id', 'user_id');
    }
}
