<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Users\Domain\Models\User;

class UpsertAppointmentRequest extends FormRequest
{
    public const string DOCTOR_ID = 'doctor_id';

    public const string USER_ID = 'user_id';

    public const string CLINIC_ID = 'clinic_id';

    public const string START_TIME = 'startTime';

    public const string END_TIME = 'endTime';

    public function rules(): array
    {
        return [
            self::DOCTOR_ID => ['required', 'integer', Rule::exists(Doctor::class, 'id')],
            self::USER_ID => ['required', 'integer', Rule::exists(User::class, 'id')],
            self::CLINIC_ID => ['required', 'integer', Rule::exists(Clinic::class, 'id')],
            self::START_TIME => ['required', 'string', 'after_or_equal:now'],
            self::END_TIME => ['required', 'string', 'after:' . self::START_TIME],
        ];
    }

    public function toDto(): AppointmentDto
    {
        return new AppointmentDto(
            doctor_id: $this->integer(self::DOCTOR_ID),
            user_id: $this->integer(self::USER_ID),
            clinic_id: $this->integer(self::CLINIC_ID),
            startTime: $this->string(self::START_TIME)->toString(),
            endTime: $this->string(self::END_TIME)->toString()
        );
    }
}
