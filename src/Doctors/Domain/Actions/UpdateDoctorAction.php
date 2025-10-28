<?php

declare(strict_types=1);

namespace Lightit\Doctors\Domain\Actions;

use Lightit\Doctors\Domain\DataTransferObjects\DoctorDto;
use Lightit\Doctors\Domain\Models\Doctor;

class UpdateDoctorAction
{
    public function execute(Doctor $doctor, DoctorDto $userDto): Doctor
    {
        $doctor->name = $userDto->name;

        $doctor->saveOrFail();

        return $doctor;
    }
}
