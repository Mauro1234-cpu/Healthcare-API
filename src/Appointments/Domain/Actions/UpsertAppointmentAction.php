<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Lightit\Appointments\App\Exceptions\OverlappingException;
use Lightit\Appointments\App\Exceptions\RelationException;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Users\Domain\Models\User;

class UpsertAppointmentAction
{
    public function __construct(
        protected ValidateDoctorOverlapping $doctorOverlapping,
        protected ValidateUserOverlapping $userOverlapping,
        protected ValidateClinicDoctorRelation $relationClinicDoctor,
    ) {
    }

    public function execute(
        AppointmentDto $appointmentDto,
        User $user,
        Appointment|null $appointment = null,
    ): Appointment {
        $appointment ??= new Appointment();

        if ($this->doctorOverlapping->execute($appointmentDto)) {
            throw new OverlappingException(subject: 'doctor');
        }

        if ($this->userOverlapping->execute($appointmentDto, $user)) {
            throw new OverlappingException(subject: 'user');
        }

        if (! $this->relationClinicDoctor->execute($appointmentDto)) {
            throw new RelationException();
        }

        $appointment = new Appointment();

        $appointment->doctor_id = $appointmentDto->doctorId;
        $appointment->user_id = $user->id;
        $appointment->clinic_id = $appointmentDto->clinicId;
        $appointment->start_time = $appointmentDto->startTime;
        $appointment->end_time = $appointmentDto->endTime;

        $appointment->saveOrFail();

        return $appointment;
    }
}
