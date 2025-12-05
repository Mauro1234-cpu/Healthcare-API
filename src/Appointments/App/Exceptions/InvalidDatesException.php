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
        $finalMessage = $this->resolveMessage($message);
        parent::__construct($finalMessage);
    }

    private function resolveMessage(Message $message): string
    {
        return match ($message) {
            Message::START => 'The start time field must be a date after or equal to now.',
            Message::END => 'The end time field must be a date after start time.'
        };
    }
}
