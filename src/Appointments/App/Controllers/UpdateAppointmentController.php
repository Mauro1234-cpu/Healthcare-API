<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Requests\UpsertAppointmentRequest;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;
use Lightit\Appointments\Domain\Models\Appointment;

final class UpdateAppointmentController
{
    public function __invoke(
        Appointment $appointment,
        UpsertAppointmentRequest $request,
        UpsertAppointmentAction $upsertAppointmentAction,
    ): JsonResponse {
        $appointment = $upsertAppointmentAction->execute($request->toDto(), $appointment);

        return AppointmentResource::make($appointment)
            ->response();
    }
}
