<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

class Meeting extends Model
{
    use HasFactory;
    
    protected $table = 'meetings';
    
    protected $fillable = [
        'description',
        'notes',
        'date',
        'URL',
        'status',
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
     * Get the project this meeting belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
