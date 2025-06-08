<?php

declare(strict_types=1);

namespace Tests\Feature\Playwright\Dummies\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PasswordResetToken extends JsonResource
{
    /** @var \Tests\Feature\Playwright\Dummies\Models\PasswordResetToken */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'token' => $this->resource->token,
            'email' => $this->resource->email,
        ];
    }
}
