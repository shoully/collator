<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mentoring;
use App\Models\User;
use App\Models\Project;

class Task extends Model
{
    use HasFactory;
    
    protected $table = 'tasks';
    
    protected $fillable = [
        'title',
        'description',
        'mentoring_id',
        'priority',
        'status',
        'mentor',
        'mentee',
        'project_id',
    ];

    /**
     * Get the mentoring this task belongs to
     */
    public function mentoring()
    {
        return $this->belongsTo(Mentoring::class, 'mentoring_id');
    }

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
     * Get the project this task belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
