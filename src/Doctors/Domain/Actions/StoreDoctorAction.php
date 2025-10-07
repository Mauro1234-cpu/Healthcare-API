<?php

declare(strict_types=1);

namespace Lightit\Doctors\Domain\Actions;

use Lightit\Doctor\Domain\DataTransferObjects\DoctorDto;
use Lightit\Doctor\Domain\Models\Doctor;

class StoreDoctorAction
{
    public function execute(DoctorDto $userDto): Doctor
    {
        $doctor = new Doctor();

        $doctor->name = $userDto->name;

        $doctor->save();

        return $doctor;
    }
}
