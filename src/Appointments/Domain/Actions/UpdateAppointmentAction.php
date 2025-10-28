<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;

class UpdateAppointmentAction
{
    public function execute(
        Appointment $appointment,
        AppointmentDto $AppointmentDto,
    ): Appointment {
        $appointment->doctor_id = $AppointmentDto->doctorId;
        $appointment->user_id = $AppointmentDto->userId;
        $appointment->clinic_id = $AppointmentDto->clinicId;
        $appointment->start_time = $AppointmentDto->startTime;
        $appointment->end_time = $AppointmentDto->endTime;

        $appointment->save();

        return $appointment;
    }
}
