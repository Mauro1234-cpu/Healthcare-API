<?php

declare(strict_types=1);

namespace Lightit\Clinics\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lightit\Appointments\Domain\Models\Appointment;
use Lightit\Doctors\Domain\Models\Doctor;

/**
 * @property int                          $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $name
 * @property string $address
 * @property string $assigned_at
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinic whereStatus($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Doctor> $doctors
 * @property-read int|null $doctors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Doctor> $doctor
 * @property-read int|null $doctor_count
 * @mixin \Eloquent
 */
class Clinic extends Model
{
    /**
     * @return BelongsToMany<Doctor, $this>
     */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class);
    }
}
