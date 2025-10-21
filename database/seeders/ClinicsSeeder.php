<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Illuminate\Database\Seeder;

class ClinicsSeeder extends Seeder
{
    public function run(): void
    {
        ClinicFactory::new()->withDoctors(1, 4)->createMany(30);
    }
}
