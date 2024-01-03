<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'started_at',
        'ended_at',
        'mentor_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Get the course's materials.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Enroll::class, 'course_id', 'student_id')->withPivot('id');
    }

    /**
     * Get the course's assignments.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function coverImage(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')
            ->whereJsonContains('data->tags', 'coverImage');
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->coverImage ? $this->coverImage->url : null;
    }

    protected static function booted(): void
    {
        parent::booted();

        static::deleting(function (Course $course) {
            $course->materials()->delete();
            $course->coverImage()->delete();
            $course->students()->detach();
        });
    }
}
