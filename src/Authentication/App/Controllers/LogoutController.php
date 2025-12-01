<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Controllers;

use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Response;
use Lightit\Authentication\Domain\Actions\LogoutAction;
use Lightit\Users\Domain\Models\User;

class LogoutController
{
    public function __invoke(#[CurrentUser] User $user, LogoutAction $logoutAction): Response
    {
        $logoutAction->execute();

        return response()->noContent();
    }
}
