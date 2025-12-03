<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\DataTransferObjects;

use Carbon\CarbonImmutable;

readonly class AppointmentDto
{
    public CarbonImmutable $startTime;

    public CarbonImmutable $endTime;

    public function __construct(
        public int $doctorId,
        public int $clinicId,
        string $startTime,
        string $endTime,
    ) {
        $this->startTime = CarbonImmutable::parse($startTime);
        $this->endTime = CarbonImmutable::parse($endTime);
    }
}
