<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Mentoring;
use App\Models\Task;
use App\Models\Document;
use App\Models\Meeting;
use App\Models\Chat;

class Project extends Model
{
    use HasFactory;
    
    protected $table = 'projects';
    
    protected $fillable = [
        'title',
        'description',
        'file',
        'filename',
        'owner',
        'project_date',
        'mentee',
        'status',
    ];
    
    protected $casts = [
        'project_date' => 'date',
    ];

    /**
     * Get the owner (mentor) user
     */
    public function ownerUser()
    {
        return $this->belongsTo(User::class, 'owner');
    }

    /**
     * Get the mentee user (if assigned)
     */
    public function menteeUser()
    {
        return $this->belongsTo(User::class, 'mentee');
    }

    /**
     * Get all mentorings for this project
     */
    public function mentorings()
    {
        return $this->hasMany(Mentoring::class, 'project_id');
    }

    /**
     * Get all tasks for this project
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    /**
     * Get all documents for this project
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'project_id');
    }

    /**
     * Get all meetings for this project
     */
    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'project_id');
    }

    /**
     * Get all chats for this project
     */
    public function chats()
    {
        return $this->hasMany(Chat::class, 'project_id');
    }
}
