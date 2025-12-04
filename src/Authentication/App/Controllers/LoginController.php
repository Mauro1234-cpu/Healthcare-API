<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Authentication\App\Requests\LoginRequest;
use Lightit\Authentication\App\Rescources\AuthResource;
use Lightit\Authentication\Domain\Actions\LoginAction;

class LoginController
{
    public function __invoke(LoginRequest $request, LoginAction $loginAction): JsonResponse
    {
        $credentials = $request->toDto();

        $auth = $loginAction->execute($credentials);

        return AuthResource::make($auth)
            ->response();
    }
}
