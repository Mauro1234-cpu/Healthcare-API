<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Requests\UpsertAppointmentRequest;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;

final class StoreAppointmentController
{
    public function __invoke(
        UpsertAppointmentAction $upsertAppointmentAction,
        UpsertAppointmentRequest $request,
    ): JsonResponse {
        $appointment = $upsertAppointmentAction->execute($request->toDto());

        return AppointmentResource::make($appointment)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
