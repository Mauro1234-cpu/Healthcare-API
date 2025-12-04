<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Rescources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lightit\Authentication\Domain\DataTransferObjects\LoginDto;

/**
 * @mixin LoginDto
 */
class AuthResource extends JsonResource
{
    /**
     * @return array{accessToken: string, tokenType: string, expiresIn: int}
     */
    public function toArray(Request $request): array
    {
        return [
            'accessToken' => $this->accessToken,
            'tokenType' => $this->tokenType,
            'expiresIn' => $this->expiresIn,
        ];
    }
}
