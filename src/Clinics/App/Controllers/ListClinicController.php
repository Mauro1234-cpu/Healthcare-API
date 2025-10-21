<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Clinics\Domain\Actions\ListClinicAction;
use Lightit\Clinics\Domain\Models\Clinic;

final class ListClinicController
{
    public function __invoke(
        ListClinicAction $action
    ): JsonResponse
    {
        $clinic = $action->execute();

        return ClinicResource::collection($clinic)
            ->response();
    }
}
