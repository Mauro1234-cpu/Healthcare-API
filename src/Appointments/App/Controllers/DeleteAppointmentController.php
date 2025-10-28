<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Controllers;

use Illuminate\Http\Response;
use Lightit\Appointments\Domain\Models\Appointment;

final class DeleteAppointmentController
{
    public function __invoke(Appointment $appointment): Response
    {
        $appointment->delete();

        return response()->noContent();
    }
}
