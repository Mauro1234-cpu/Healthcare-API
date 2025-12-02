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
     * @return array{accessToken: string, tokenType: string, expiresIn: int}
     */
    public function toArray(Request $request): array
    {
        return [
            'accessToken' => $this->resource->accessToken,
            'tokenType' => $this->resource->tokenType,
            'expiresIn' => $this->resource->expiresIn,
        ];
    }
}
