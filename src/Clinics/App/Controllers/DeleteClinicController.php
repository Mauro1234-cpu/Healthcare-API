<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Illuminate\Http\Response;
use Lightit\Clinics\Domain\Models\Clinic;

final class DeleteClinicController
{
    public function __invoke(Clinic $clinic): Response
    {
        $clinic->delete();

        return response()->noContent();
    }
}
