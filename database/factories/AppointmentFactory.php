<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Users\Domain\Models\User;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $appointmentDuration = rand(15, 100);
        $startTime = CarbonImmutable::now();
        $endTime = $startTime->addMinutes($appointmentDuration);

        return [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'doctor_id' => DoctorFactory::new(),
            'user_id' => UserFactory::new(),
            'clinic_id' => ClinicFactory::new()
        ];
    }
}

//...

$doctors = 
$clinics = 10

AppointmentFactory::new()->recycle($doctors)->createOne();

