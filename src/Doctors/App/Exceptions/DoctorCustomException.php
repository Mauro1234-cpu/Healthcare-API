<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CustomException extends Exception
{
    public function render(): Response
    {
        $success = 'Error 409';
        $message = 'El doctor ya tiene una cita agendada en este horario';

        return response(['success' => $success, 'message' => $message])
        ->setStatusCode(JsonResponse::HTTP_CONFLICT);
    }
}
