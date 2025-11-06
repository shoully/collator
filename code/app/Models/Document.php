<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'document',
        'ext',
        'filename',
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
     * Get the project this document belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
