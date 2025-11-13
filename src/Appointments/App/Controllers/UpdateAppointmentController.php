<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Requests\UpsertAppointmentRequest;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\Domain\Models\User;

final class UpdateAppointmentController
{
    public function __invoke(
        Appointment $appointment,
        UpsertAppointmentRequest $request,
        UpsertAppointmentAction $upsertAppointmentAction,
        #[CurrentUser]
        User $user,
    ): JsonResponse {
        $appointment = $upsertAppointmentAction->execute(
            appointmentDto: $request->toDto(),
            user: $user,
            appointment: $appointment
        );

        return AppointmentResource::make($appointment)
            ->response();
    }
}
