<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;

/**
 * @extends Factory<Clinic>
 */
class ClinicFactory extends Factory
{
    protected $model = Clinic::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Medical',
            'address' => fake()->address()
        ];
    }

    public function withDoctors(): self
    {
        return $this->afterCreating(function (Clinic $clinic) {
            $count = rand(2, 6);
            $doctors = DoctorFactory::new()->recycle($clinic)->count($count)->create();
            $clinic->doctors()->attach($doctors);
        });
    }
}
