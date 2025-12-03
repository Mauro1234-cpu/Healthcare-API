<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Exceptions;

use Illuminate\Http\JsonResponse;
use Lightit\Appointments\Domain\Enums\Message;
use Lightit\Shared\App\Exceptions\Http\HttpException;

class InvalidDatesException extends HttpException
{
    protected int $status = JsonResponse::HTTP_CONFLICT;

    protected string $errorCode = 'APPOINTMENT_INVALID_DATES';

    public function __construct(Message $message)
    {
        parent::__construct($message->value);
    }
}
