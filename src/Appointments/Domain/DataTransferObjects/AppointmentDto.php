<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\DataTransferObjects;

readonly class AppointmentDto
{
    public function __construct(
        public int $doctorId,
        public int $userId,
        public int $clinicId,
        public string $startTime,
        public string $endTime,
    ) {
    }
}
