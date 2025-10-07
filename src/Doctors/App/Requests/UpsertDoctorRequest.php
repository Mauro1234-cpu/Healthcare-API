<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\Doctor\Domain\DataTransferObjects\DoctorDto;

class UpsertDoctorRequest extends FormRequest
{
    public const string NAME = 'name';

    public function authorize(): bool
    {
        return false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var $doctor|null $doctor */
        $doctor = $this->route('doctor');

        return [
            self::NAME => ['required', 'string', 'min:4', 'max:4']
        ];
    }

    public function toDto(): DoctorDto
    {
        return new DoctorDto(
            name: $this->string(self::NAME)->toString(),
        );
    }
}
