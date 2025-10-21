<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\DoctorFactory;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $factory = new DoctorFactory();
        $factory->createMany(10);
    }
}
