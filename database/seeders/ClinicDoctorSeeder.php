<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;

class ClinicDoctorSeeder extends Seeder
{
    public function run(): void
    {
        $clinics = Clinic::all();
        $doctors = Doctor::all();

        // foreach ($clinics as $clinic){
        //     $clinic->doctors()->attach(
        //         $doctors->random(rand(1, 3))->pluck()
        //     )
        // }
    }
}
