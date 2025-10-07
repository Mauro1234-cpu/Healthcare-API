<?php

declare(strict_types=1);

namespace Lightit\Doctor\Domain\Actions;

use Lightit\Doctor\Domain\DataTransferObjects\DoctorDto;
use Lightit\Doctor\Domain\Models\Doctor;

class UpdateDoctorAction
{
    public function execute(Doctor $doctor,DoctorDto $userDto): Doctor
    {
        $doctor->name = $userDto->name;

        $doctor->save();

        return $doctor;
    }
}
