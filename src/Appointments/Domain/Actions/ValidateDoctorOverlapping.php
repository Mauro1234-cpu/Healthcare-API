<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;

class ValidateDoctorOverlapping
{
    public function execute(AppointmentDto $appointmentDto): bool
    {
        return Appointment::query()
        ->where('doctor_id', $appointmentDto->doctorId)
        ->where(function ($q) use ($appointmentDto): void {
            $q->whereBetween('start_time', [$appointmentDto->startTime, $appointmentDto->endTime])
            ->orWhereBetween('end_time', [$appointmentDto->startTime, $appointmentDto->endTime]);
        })
        ->exists();
    }
}
