<?php

namespace App\Enumerations;

use App\Traits\Enum\Finder;

enum Moderation: string
{
    use Finder;

    case pending = 'pending';
    case draft = 'draft';
    case accepted = 'accepted';
    case active = 'active';
    case closed = 'closed';
    case rejected = 'rejected';
    case suspended = 'suspended';
    case blocked = 'blocked';
}
