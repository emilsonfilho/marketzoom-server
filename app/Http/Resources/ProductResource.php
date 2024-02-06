<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'shop_id' => $this->shop_id,
            'name' => $this->name,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            'details' => $this->details,
            'image' => $this->image,
            'total_ratings' => $this->total_ratings,
            'average_rating' => $this->average_rating,
            'user' => new UserResource($this->whenLoaded('user')),
            'shop' => new ShopResource($this->whenLoaded('shop')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
