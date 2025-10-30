<?php

declare(strict_types=1);

namespace Lightit\Users\Domain\Actions;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Lightit\Users\Domain\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spaze\PHPStan\Rules\Disallowed\Allowed\Allowed;

class ListUserAction
{
    /**
     * @return LengthAwarePaginator<int, User>
     */
    public function execute(): LengthAwarePaginator
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::callback('appointments', function (Builder $query) {
                    $query->whereHas('appointments');
                }),
                'email'
                ])
            ->allowedSorts('email')
            ->orderBy('id', 'desc')
            ->paginate();
    }
}
