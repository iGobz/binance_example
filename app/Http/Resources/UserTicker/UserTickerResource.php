<?php

namespace App\Http\Resources\UserTicker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTickerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticker' => $this->ticker
        ];
    }
}
