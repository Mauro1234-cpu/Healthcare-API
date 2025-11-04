<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;

class UpsertAppointmentRequest extends FormRequest
{
    public const string DOCTOR_ID = 'doctorId';

    public const string USER_ID = 'userId';

    public const string CLINIC_ID = 'clinicId';

    public const string START_TIME = 'startTime';

    public const string END_TIME = 'endTime';

    public function rules(): array
    {
        return [
            self::DOCTOR_ID => ['required', 'integer'],
            self::USER_ID => ['required', 'integer'],
            self::CLINIC_ID => ['required', 'integer'],
            self::START_TIME => ['required', 'string', 'after_or_equal:now'],
            self::END_TIME => ['required', 'string', 'after:' . self::START_TIME],
        ];
    }

    public function toDto(): AppointmentDto
    {
        return new AppointmentDto(
            doctorId: $this->integer(self::DOCTOR_ID),
            userId: $this->integer(self::USER_ID),
            clinicId: $this->integer(self::CLINIC_ID),
            startTime: $this->string(self::START_TIME)->toString(),
            endTime: $this->string(self::END_TIME)->toString()
        );
    }
}
