<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Lightit\Shared\App\Exceptions\Http\HttpException;

class OverlappingException extends HttpException
{
    public function render(): Response
    {
        $status = 409;
        $message = 'This ' . $this->message . ' has an appointment scheduled at this time.';

        return response(['status' => $status, 'message' => $message])
        ->setStatusCode(JsonResponse::HTTP_CONFLICT);
    }
}
