<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RelationException extends Exception
{
    public function render(): Response
    {
        $success = 'Error 409';
        $message = 'Este médico no trabaja en esta clinica';

        return response(['success' => $success, 'message' => $message])
        ->setStatusCode(JsonResponse::HTTP_CONFLICT);
    }
}
