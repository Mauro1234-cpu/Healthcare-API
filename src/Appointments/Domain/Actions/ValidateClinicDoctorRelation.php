<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Illuminate\Support\Facades\DB;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;

class ValidateClinicDoctorRelation
{
    public function execute(AppointmentDto $appointmentDto): bool
    {
        return DB::table('clinic_doctor')
            ->where('doctor_id', $appointmentDto->doctor_id)
            ->where('clinic_id', $appointmentDto->clinic_id)
            ->exists();
    }
}
