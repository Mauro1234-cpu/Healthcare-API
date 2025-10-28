<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Requests\UpsertClinicRequest;
use Lightit\Clinics\App\Resources\ClinicResource as ResourcesClinicResource;
use Lightit\Clinics\Domain\Actions\UpdateClinicAction;
use Lightit\Clinics\Domain\Models\Clinic;

final class UpdateClinicController
{
    public function __invoke(
        Clinic $clinic,
        UpsertClinicRequest $request,
        UpdateClinicAction $updateClinicAction,
    ): JsonResponse {
        $clinic = $updateClinicAction->execute($clinic, $request->toDto());

        return ResourcesClinicResource::make($clinic)
            ->response();
    }
}
