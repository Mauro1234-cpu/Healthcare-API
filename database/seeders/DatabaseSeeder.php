<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DoctorSeeder::class,
            ClinicSeeder::class,
            UserSeeder::class,
            UserFactory::new()->createMany(35)
        ]);

        $this->call([
            DoctorSeeder::class,
        ]);
    }
}
