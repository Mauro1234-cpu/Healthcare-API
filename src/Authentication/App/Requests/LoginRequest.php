<?php

declare(strict_types=1);

namespace Lightit\Authentication\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\Authentication\Domain\DataTransferObjects\LoginInputDto;

class LoginRequest extends FormRequest
{
    public const string EMAIL = 'email';

    public const string PASSWORD = 'password';

    public function rules(): array
    {
        return [
            self::EMAIL => ['required', Rule::email()->strict()],
            self::PASSWORD => ['required'],
        ];
    }

    public function toDto(): LoginInputDto
    {
        return new LoginInputDto(
            email: $this->string(LoginRequest::EMAIL)->toString(),
            password: $this->string(LoginRequest::PASSWORD)->toString()
        );
    }
}
