<?php

declare(strict_types=1);

namespace Lightit\Clinics\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Clinics\App\Requests\UpsertClinicRequest;
use Lightit\Clinics\App\Resources\ClinicResource;
use Lightit\Clinics\Domain\Actions\StoreClinicAction;

final class StoreClinicController
{
    public function __invoke(
        StoreClinicAction $storeClinicAction,
        UpsertClinicRequest $request,
    ): JsonResponse {
        $clinic = $storeClinicAction->execute($request->toDto());

        return ClinicResource::make($clinic)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }
}
