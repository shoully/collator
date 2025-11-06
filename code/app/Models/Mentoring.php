<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;

class Mentoring extends Model
{
    use HasFactory;
    
    protected $table = 'mentoring';
    
    protected $fillable = [
        'title',
        'mentor',
        'mentee',
        'project_id',
    ];

    /**
     * Get the mentor user
     */
    public function mentorUser()
    {
        return $this->belongsTo(User::class, 'mentor');
    }

    /**
     * Get the mentee user
     */
    public function menteeUser()
    {
        return $this->belongsTo(User::class, 'mentee');
    }

    /**
     * Get tasks for this mentoring
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'mentoring_id');
    }

    /**
     * Get the project this mentoring belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
