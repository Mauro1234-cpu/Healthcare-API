<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\DoctorFactory;
use Database\Factories\ClinicFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DoctorSeeder::class,
            ClinicsSeeder::class,
            UserSeeder::class,
            AppointmentsSeeder::class,
        ]);


        // Crear una clinica asociada a un doctor que se crea a la vez
        // $doctor = DoctorFactory::new()->createOne(['name' => 'Mauro']);
        // ClinicFactory::new()->withDoctors($doctor)->createOne([
        //     'name' => 'Hospital Pereira Rosell'
        // ]);


    }
}
