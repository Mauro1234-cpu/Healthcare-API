<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Users\Domain\Models\User;

/**
 * @extends Factory<\Lightit\Shared\App\Appointments>
 */
class AppointmentsFactory extends Factory
{
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
}
