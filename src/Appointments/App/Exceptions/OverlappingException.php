<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Exceptions;

use Illuminate\Http\JsonResponse;
use Lightit\Appointments\Domain\Enums\Subject;
use Lightit\Shared\App\Exceptions\Http\HttpException;

class OverlappingException extends HttpException
{
    protected int $status = JsonResponse::HTTP_CONFLICT;

    protected string $errorCode = 'APPOINTMENT_OVERLAP';

    public function __construct(protected Subject $subject)
    {
        parent::__construct(message: 'This ' . $this->subject->value . ' has an appointment scheduled at this time.');
    }
}
