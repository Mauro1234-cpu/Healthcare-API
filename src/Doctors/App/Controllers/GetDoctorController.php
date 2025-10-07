<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Doctors\App\Resources\DoctorResource;
use Lightit\Doctors\Domain\Models\Doctor;

final readonly class GetDoctorController
{
    public function __invoke(Doctor $doctor): JsonResponse
    {
        return DoctorResource::make($doctor)
            ->response();
    }
}
