<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Lightit\Appointments\App\Exceptions\CustomException;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;

class UpdateAppointmentAction
{
    public function __construct(
        protected ValidateDoctorOverlapping $doctorOverlapping,
        protected ValidateUserOverlapping $userOverapping,
    ) {
    }

    public function execute(
        Appointment $appointment,
        AppointmentDto $appointmentDto,
    ): Appointment {
        if ($this->doctorOverlapping->execute($appointmentDto)) {
            throw new CustomException(message: 'doctor');
        }

        if ($this->userOverapping->execute($appointmentDto)) {
            throw new CustomException(message: 'usuario');
        }

        $appointment->doctor_id = $appointmentDto->doctor_id;
        $appointment->user_id = $appointmentDto->user_id;
        $appointment->clinic_id = $appointmentDto->clinic_id;
        $appointment->start_time = $appointmentDto->startTime;
        $appointment->end_time = $appointmentDto->endTime;

        $appointment->saveOrFail();

        return $appointment;
    }
}
