<?php

declare(strict_types=1);

namespace Database\Factories;

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
        return [
            'start_time' => $start = fake()->dateTime(),
            'end_time' => (clone $start)->modify('+' . fake()->numberBetween(15, 100) . 'minutes'),
            'doctor_id' => Doctor::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'clinic_id' => Clinic::all()->random()->id
        ];
    }

    // /**
    //  * @param Collection<int, Doctor> $doctors
    //  * @param Collection<int, Clinic> $clinics
    //  * @param Collection<int, User> $users
    //  */
    // public function withRelations(Collection $clinics, Collection $doctors, Collection $users): self
    // {
    //     return $this->afterMaking(function (Appointment $appointment) use ($clinics, $doctors, $users) {
    //         $appointment->clinic_id = $clinics->random()->id;
    //         $appointment->user_id = $users->random()->id;
    //         $appointment->doctor_id = $doctors->random()->id;
    //     });
    // }
}
