<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Material extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'course_id',
        'mentor_id',
    ];

    protected static function booted(): void
    {
        parent::booted();

        static::deleting(function (Material $material) {
            $material->assignment()->delete();
            $material->attachments()->delete();
        });
    }

    /**
     * Get the material's attachments.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function video(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')
            ->whereJsonContains('data->tags', 'embed');
    }

    public function getVideoUrlAttribute(): ?string
    {
        return $this->video ? $this->video->data['url'] : null;
    }

    /**
     * Get the material's comments.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the material's assignment.
     */
    public function assignment(): HasOne
    {
        return $this->hasOne(Assignment::class);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
