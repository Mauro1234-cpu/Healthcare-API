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
            ClinicSeeder::class,
            UserSeeder::class,
            AppointmentSeeder::class,
        ]);
    }
}
