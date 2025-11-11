<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Lightit\Shared\App\Exceptions\Http\HttpException;

class RelationException extends HttpException
{
    public function render(): Response
    {
        $status = 409;
        $message = 'This doctor does not work at this clinic';

        return response(['status' => $status, 'message' => $message])
        ->setStatusCode(JsonResponse::HTTP_CONFLICT);
    }
}
