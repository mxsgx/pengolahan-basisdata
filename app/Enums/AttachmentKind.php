<?php

namespace App\Enums;

enum AttachmentKind: string
{
    case FILE = 'file';
    case LINK = 'link';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
