<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\ClinicFactory;
use Illuminate\Database\Seeder;

class ClinicsSeeder extends Seeder
{
    public function run(): void
    {
        ClinicFactory::new()->withDoctors()->createMany(30);
    }
}
