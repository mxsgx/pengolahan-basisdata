<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Submission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'grade',
        'status',
        'assignment_id',
        'student_id',
    ];

    /**
     * Get the submission's attachments.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    protected static function booted(): void
    {
        parent::booted();

        static::deleting(function (Submission $submission) {
            $submission->attachments()->delete();
        });
    }
}
