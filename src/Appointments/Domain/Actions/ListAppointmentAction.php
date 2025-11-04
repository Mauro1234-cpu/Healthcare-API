<?php

declare(strict_types=1);

namespace Lightit\Appointments\Domain\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\Appointments\Domain\Models\Appointment;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ListAppointmentAction
{
    /**
     * @return LengthAwarePaginator<int, Appointment>
     */
    public function execute(): LengthAwarePaginator
    {
        return QueryBuilder::for(Appointment::class)
            ->allowedFilters([
                AllowedFilter::belongsTo('clinic'),
                AllowedFilter::belongsTo('doctor'),
                AllowedFilter::belongsTo('user'),
                ])
            ->with(['clinic', 'doctor', 'user'])
            ->orderBy('id', 'asc')
            ->paginate();
    }
}
