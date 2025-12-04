<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Mentoring;
use App\Models\Task;
use App\Models\Meeting;
use App\Models\Document;
use App\Models\Chat;

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
        'email',
        'password',
        'phone',
        'bio',
        'type',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get mentorings where this user is the mentor
     */
    public function mentorings()
    {
        return $this->hasMany(Mentoring::class, 'mentor');
    }

    /**
     * Get mentorings where this user is the mentee
     */
    public function menteeMentorings()
    {
        return $this->hasMany(Mentoring::class, 'mentee');
    }

    /**
     * Get tasks where this user is the mentee
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'mentee');
    }

    /**
     * Get tasks where this user is the mentor
     */
    public function mentorTasks()
    {
        return $this->hasMany(Task::class, 'mentor');
    }

    /**
     * Get meetings where this user is the mentee
     */
    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'mentee');
    }

    /**
     * Get meetings where this user is the mentor
     */
    public function mentorMeetings()
    {
        return $this->hasMany(Meeting::class, 'mentor');
    }

    /**
     * Get documents where this user is the mentee
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'mentee');
    }

    /**
     * Get chats where this user is the mentee
     */
    public function chats()
    {
        return $this->hasMany(Chat::class, 'mentee');
    }

    /**
     * Get chats where this user is the mentor
     */
    public function mentorChats()
    {
        return $this->hasMany(Chat::class, 'mentor');
    }
}
