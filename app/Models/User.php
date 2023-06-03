<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'alias',
        'birthday',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['label'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['tasksPanels'];
    public function getLabelAttribute()
    {
        $label = $this->label = $this->name . ' ' . $this->lastname;
        return $label;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function tasksAssigned()
    {
        return $this->belongsToMany(
            Task::class,
            'user_has_tasks',
            'user_id',
            'task_id'
        );
    }

    public function tasksPanels()
    {
        return $this->belongsToMany(
            TasksPanel::class,
            'users_in_tasks_panels',
            'user_id',
            'tasks_panel_id'
        );
    }

    public function can($abilities, $arguments = [])
    {
        return app(\Illuminate\Contracts\Auth\Access\Gate::class)->forUser($this)->check($abilities, $arguments);
    }
}
