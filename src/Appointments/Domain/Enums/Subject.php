<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Enums;

enum Subject: string
{
    case DOCTOR = 'doctor';
    case USER = 'user';
}
