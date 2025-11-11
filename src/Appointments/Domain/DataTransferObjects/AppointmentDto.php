<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\DataTransferObjects;

readonly class AppointmentDto
{
    public function __construct(
        public int $doctor_id,
        public int $user_id,
        public int $clinic_id,
        public string $startTime,
        public string $endTime,
    ) {
    }
}
