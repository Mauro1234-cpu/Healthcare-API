<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\JsonResponse;
use Lightit\Appointments\App\Requests\UpsertAppointmentRequest;
use Lightit\Appointments\App\Resources\AppointmentResource;
use Lightit\Appointments\Domain\Actions\UpsertAppointmentAction;
use Lightit\Users\Domain\Models\User;

final class StoreAppointmentController
{
    public function __invoke(
        UpsertAppointmentAction $upsertAppointmentAction,
        UpsertAppointmentRequest $request,
        #[CurrentUser]
        User $user,
    ): JsonResponse {
        $appointment = $upsertAppointmentAction->execute(appointmentDto: $request->toDto(), user: $user);

        return AppointmentResource::make($appointment)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
