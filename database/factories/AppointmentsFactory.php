<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\Lightit\Shared\App\Appointments>
 */
class AppointmentsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'docto'
        ];
    }
}
