<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Enums;

enum Message: string
{
    case START = 'The start time field must be a date after or equal to now.';
    case END = 'The end time field must be a date after start time.';
}
