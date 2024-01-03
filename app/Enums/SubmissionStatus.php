<?php

namespace App\Enums;

enum SubmissionStatus: string
{
    case MISSING = 'missing';
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
