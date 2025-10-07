<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lightit\Doctor\Domain\Models\Doctor;
use Lightit\Doctors\App\Resources\DoctorResource;

final readonly class GetDoctorController
{
    public function __invoke(Doctor $doctor): JsonResponse
    {
        return DoctorResource::make($doctor)
            ->response();
    }
}
