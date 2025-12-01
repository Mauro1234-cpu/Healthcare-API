<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Rescources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Lightit\Authentication\Domain\DataTransferObjects\LoginDto;

class RefreshResource extends JsonResource
{
    /**
     * @var LoginDto
     */
    public $resource;

    /**
     * @return array{access_token: string, token_type: string, expires_in: int}
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->resource->accessToken,
            'token_type' => $this->resource->tokenType,
            'expires_in' => $this->resource->expiresIn,
        ];
    }
}
