<?php

namespace App\Models;

use App\Enums\AttachmentKind;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kind',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'kind' => AttachmentKind::class,
        'data' => 'array',
    ];

    /**
     * Get the parent attachable model.
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): ?string
    {
        return $this->data ? Storage::disk('s3')->url($this->data['path']) : null;
    }

    protected static function booted(): void
    {
        parent::booted();

        static::deleting(function (Attachment $attachment) {
            if ($attachment->kind != AttachmentKind::LINK) {
                return;
            }

            if (Storage::disk('s3')->exists($attachment->data['path'])) {
                Storage::disk('s3')->delete($attachment->data['path']);
            }
        });
    }
}
