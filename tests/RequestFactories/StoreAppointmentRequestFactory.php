<?php

declare(strict_types=1);

namespace Tests\RequestFactories;

use Carbon\CarbonImmutable;
use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Worksome\RequestFactories\RequestFactory;

class StoreAppointmentRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $appointmentDuration = rand(15, 100);
        $startTime = CarbonImmutable::now();
        $endTime = $startTime->addMinutes($appointmentDuration);

        return [
            'doctor_id' => DoctorFactory::new(),
            'clinic_id' => ClinicFactory::new(),
            'start_time' => $startTime,
            'end_time' => $endTime,
        ];
    }
}
