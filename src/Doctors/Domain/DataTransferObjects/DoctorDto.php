<?php

declare(strict_types=1);

namespace Lightit\Doctors\Domain\DataTransferObjects;

class DoctorDto
{
    public function __construct(
        public readonly string $name,
    ) {
    }
}
