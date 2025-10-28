<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Clinics\Domain\Models\Clinic;

final class GetClinicController
{
    public function __invoke(Clinic $clinic): JsonResponse
    {
        return ClinicResource::make($clinic)
            ->response();
    }
}
