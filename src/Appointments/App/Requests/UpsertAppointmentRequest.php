<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Appointments\Domain\DataTransferObjects\AppointmentDto;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;

class UpsertAppointmentRequest extends FormRequest
{
    public const string DOCTOR_ID = 'doctorId';

    public const string CLINIC_ID = 'clinicId';

    public const string START_TIME = 'startTime';

    public const string END_TIME = 'endTime';

    public function rules(): array
    {
        return [
            self::DOCTOR_ID => ['required', 'integer', Rule::exists(Doctor::class, 'id')],
            self::CLINIC_ID => ['required', 'integer', Rule::exists(Clinic::class, 'id')],
            self::START_TIME => ['required', 'string', 'after_or_equal:now'],
            self::END_TIME => ['required', 'string', 'after:' . self::START_TIME],
        ];
    }

    public function toDto(): AppointmentDto
    {
        /** @var string $start */
        $start = $this->input(self::START_TIME);
        /** @var string $end */
        $end = $this->input(self::END_TIME);

        return new AppointmentDto(
            doctorId: $this->integer(self::DOCTOR_ID),
            clinicId: $this->integer(self::CLINIC_ID),
            startTime: CarbonImmutable::parse($end),
            endTime: CarbonImmutable::parse($start)
        );
    }
}
