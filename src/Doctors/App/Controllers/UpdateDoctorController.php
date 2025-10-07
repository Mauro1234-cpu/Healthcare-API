<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lightit\Doctor\Domain\Actions\UpdateDoctorAction;
use Lightit\Doctor\Domain\Models\Doctor;
use Lightit\Doctors\App\Requests\UpsertDoctorRequest;
use Lightit\Doctors\App\Resources\DoctorResource;

final readonly class UpdateDoctorController
{
    public function __invoke(Doctor $doctor, UpsertDoctorRequest $request, UpdateDoctorAction $updateDoctorAction): JsonResponse
    {
        $doctor = $updateDoctorAction->execute($doctor, $request->toDto());

        return DoctorResource::make($doctor)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
