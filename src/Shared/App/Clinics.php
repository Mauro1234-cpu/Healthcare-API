<?php

declare(strict_types=1);

namespace Lightit\Shared\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int                          $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinics query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Clinics whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Clinics extends Model
{
    use HasFactory;

    public function doctor()
    {
        return $this->belongsToMany(Doctor::class);
    }
}
