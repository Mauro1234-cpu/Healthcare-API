<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Controllers;

use Illuminate\Http\Response;
use Lightit\Doctors\Domain\Models\Doctor;

final class DeleteDoctorController
{
    public function __invoke(Doctor $doctor): Response
    {
        $doctor->delete();

        return response()->noContent();
    }
}
