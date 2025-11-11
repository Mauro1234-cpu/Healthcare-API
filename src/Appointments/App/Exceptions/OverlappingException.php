<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OverlappingException extends Exception
{
    public function render(): Response
    {
        $success = 'Error 409';
        $message = 'El ' . $this->message . ' ya tiene una cita agendada en este horario.';

        return response(['success' => $success, 'message' => $message])
        ->setStatusCode(JsonResponse::HTTP_CONFLICT);
    }
}
