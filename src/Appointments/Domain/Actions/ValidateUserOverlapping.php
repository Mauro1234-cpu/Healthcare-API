<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;

class ValidateUserOverlapping
{
    public function execute(AppointmentDto $appointmentDto): bool
    {
        return Appointment::query()
        ->where('user_id', $appointmentDto->userId)
        ->where(function ($q) use ($appointmentDto): void {
            $q->whereBetween('start_time', [$appointmentDto->startTime, $appointmentDto->endTime])
            ->orWhereBetween('end_time', [$appointmentDto->startTime, $appointmentDto->endTime]);
        })
        ->exists();
    }
}
