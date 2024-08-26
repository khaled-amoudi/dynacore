<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource\BaseResource;
use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'image' => image_url($this->image),
            'description' => $this->description,
            'is_active' => $this->is_active,
            'items' => ItemResource::collection($this->whenLoaded('items'))->toArray($request),
        ];
    }

}
