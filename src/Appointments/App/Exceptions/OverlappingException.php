<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Exceptions;

use Illuminate\Http\JsonResponse;
use Lightit\Shared\App\Exceptions\Http\HttpException;

class OverlappingException extends HttpException
{
    protected int $status = JsonResponse::HTTP_CONFLICT;

    protected string $errorCode = 'APPOINTMENT_OVERLAP';

    public function __construct(protected string $subject)
    {
        parent::__construct(message: 'This ' . $this->subject . ' has an appointment scheduled at this time.');
    }
}
