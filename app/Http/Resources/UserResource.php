<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $model = 'App\Models\User';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_type_id' => $this->user_type_id,
            'shop_id' => $this->shop_id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'profile' => $this->profile,
            'user_type' => new UserTypeResource($this->whenLoaded('userType')),
            'shop' => new ShopResource($this->whenLoaded('shop')),
        ];
    }
}
