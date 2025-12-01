<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\Authentication\App\Requests\LoginRequest;
use Lightit\Authentication\App\Rescources\LoginResource;
use Lightit\Authentication\Domain\Actions\LoginAction;
use Lightit\Authentication\Domain\DataTransferObjects\LoginInputDto;

class LoginController
{
    public function __invoke(LoginRequest $request, LoginAction $loginAction): JsonResponse
    {
        $dto = new LoginInputDto(
            email: LoginRequest::EMAIL,
            password: LoginRequest::PASSWORD
        );

        $loginDto = $loginAction->execute($dto);

        return LoginResource::make($loginDto)
            ->response()
            ->setStatusCode(JsonResponse::HTTP_OK);
    }
}
