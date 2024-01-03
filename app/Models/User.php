<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
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
        'email',
        'password',
        'field',
        'contact',
        'role',
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
        'password' => 'hashed',
        'role' => UserRole::class,
    ];

    /**
     * Get the user's profile picture.
     */
    public function profilePicture(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function getProfilePictureUrlAttribute(): string
    {
        return $this->profilePicture ? $this->profilePicture->url : 'https://placehold.co/512?text='.str($this->name)->substr(0, 1);
    }

    /**
     * Get the user's enrolled courses (student).
     */
    public function enrolledCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, Enroll::class, 'student_id', 'course_id');
    }

    /**
     * Get the user's mentored courses (mentor).
     */
    public function mentoredCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'mentor_id');
    }
}
