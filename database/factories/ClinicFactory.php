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
            'address' => fake()->streetAddress() . ', ' . fake()->city()
        ];
    }

    public function withDoctors(int $min, int $max): self
    {
        return $this->afterCreating(function (Clinic $clinic) use ($min, $max) {
            $count = rand($min, $max);
            $doctors = DoctorFactory::new()->createMany($count);
            $clinic->doctors()->attach($doctors, ['active' => true]);
        });
    }



    // Crear clinicas relacionadas a doctores previamente creados
    //**
    //  * @param Collection<int, Doctor> $doctors
    //  */
    // public function withDoctors(Collection $doctors): self
    // {
    //     return $this->afterCreating(function (Clinic $clinic) use ($doctors) {
    //         $clinic->doctors()->attach($doctors, ['active' => true]);
    //     });
    // }

    // Crear una clinica asociada a un doctor que se crea a la vez
    // public function withDoctor(Doctor $doctor): self
    // {
    //     return $this->afterCreating(function (Clinic $clinic) use ($doctor) {
    //         $clinic->doctors()->attach($doctor, ['active' => true]);
    //     });
    // }
}
