<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Exceptions;

use Illuminate\Http\JsonResponse;
use Lightit\Shared\App\Exceptions\Http\HttpException;

class RelationException extends HttpException
{
    protected int $status = JsonResponse::HTTP_CONFLICT;

    protected string $errorCode = 'APPOINTMENT_OVERLAP';

    public function __construct()
    {
        parent::__construct('This doctor does not work at this clinic');
    }
}
