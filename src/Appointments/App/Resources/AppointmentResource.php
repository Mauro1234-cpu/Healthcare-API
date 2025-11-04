<?php

declare(strict_types=1);

namespace Lightit\Appointments\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lightit\Appointments\Domain\Models\Appointment;

/**
 * @mixin Appointment
 */
class AppointmentResource extends JsonResource
{
    /**
     * @return array{
     *   id: int, doctor_id: int, user_id: int, clinic_id: int, start_time: string, end_time: string, doctor_name: mixed, user_name: mixed, clinic_name: mixed
     * }
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'user_id' => $this->user_id,
            'clinic_id' => $this->clinic_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'doctor_name' => $this->whenLoaded('doctor', fn () => $this->doctor->name),
            'user_name' => $this->whenLoaded('user', fn () => $this->user->name),
            'clinic_name' => $this->whenLoaded('clinic', fn () => $this->clinic->name),
        ];
    }
}
