<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\AppointmentFactory;
use Database\Factories\ClinicFactory;
use Database\Factories\DoctorFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Users\Domain\Models\User;

class AppointmentsSeeder extends Seeder
{
    public function run(): void
    {
        $clinics = Clinic::all();
        $doctors = Doctor::all();
        $users = User::all();

        if ($clinics->isEmpty()){
            $clinics = ClinicFactory::new()->createMany(5);
        }
        if ($doctors->isEmpty()){
            $doctors = DoctorFactory::new()->createMany(10);
        }
        if ($users->isEmpty()){
            $users = UserFactory::new()->createMany(15);
        }

        AppointmentFactory::new()->createMany(30);
    }
}
