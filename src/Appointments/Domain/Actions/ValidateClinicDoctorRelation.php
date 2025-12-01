<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Doctors\Domain\Models\Doctor;

class ValidateClinicDoctorRelation
{
    public function execute(AppointmentDto $appointmentDto): bool
    {
        return Doctor::whereId($appointmentDto->doctor_id)
            ->whereRelation('clinics', 'id', $appointmentDto->clinic_id)
            ->exists();
    }
}
