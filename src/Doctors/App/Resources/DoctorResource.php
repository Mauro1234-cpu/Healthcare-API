<?php

declare(strict_types=1);

namespace Lightit\Doctors\App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lightit\Doctors\Domain\Models\Doctor;

/**
 * @mixin Doctor
 */
class DoctorResource extends JsonResource
{
    /**
     * @return array{id: int, name: string}
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'clinics_count'=> $this->clinics()->count(),
        ];
    }
}
