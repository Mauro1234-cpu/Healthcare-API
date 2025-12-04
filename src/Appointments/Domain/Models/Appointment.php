<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lightit\Clinics\Domain\Models\Clinic;
use Lightit\Doctors\Domain\Models\Doctor;
use Lightit\Users\Domain\Models\User;

/**
 * @property int                     $id
 * @property int                     $doctor_id
 * @property int                     $clinic_id
 * @property int                     $user_id
 * @property \Carbon\CarbonImmutable $start_time
 * @property \Carbon\CarbonImmutable $end_time
 * @property \Carbon\CarbonImmutable $created_at
 * @property \Carbon\CarbonImmutable $updated_at
 * @property-read Clinic $clinic
 * @property-read Doctor $doctor
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUserId($value)
 *
 * @property-read Clinic|null $clinics
 * @property-read Doctor|null $doctors
 * @property-read User|null $users
 * @property \Carbon\CarbonImmutable|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'start_time' => 'immutable_datetime',
        'end_time' => 'immutable_datetime',
    ];

    /**
     * @return BelongsTo<Doctor, $this>
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * @return BelongsTo<Clinic, $this>
     */
    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
