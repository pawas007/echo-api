<?php

namespace App\Http\Resources;

use App\Models\Friend;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use JsonSerializable;

class UserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return bool|array|string|JsonSerializable|Arrayable
     */
    public function getStatus(): bool|array|string|JsonSerializable|Arrayable
    {
        $authUser = Auth::user();
        $pending = collect($authUser->friendPendingRequest)->pluck('id')->contains($this->id);
        if ($pending) {
            return Friend::STATUS_PENDING;
        }
        $friend = collect($authUser->friends)->pluck('id')->contains($this->id);
        if ($friend) {
            return Friend::STATUS_ACCEPTED;
        }
        return false;
    }

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->getStatus(),
            'profile' => $this->profile,
            'if_online' => $this->if_online,
        ];
    }
}
