<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource\BaseResource;

class ItemResource extends BaseResource
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
            // // relation
            'category_id' => $this->category_id,
            'category_id_name' => optional($this->category)->name,
            // // image
            'image' => image_url($this->image),

            // // translatable
            'name' => $this->translation('name'),
            'name_en' => $this->getTranslations('name')['en'] ?? '',
            'name_ar' => $this->getTranslations('name')['ar'] ?? '',
            'description' => $this->translation('description'),
            'description_en' => $this->getTranslations('description')['en'] ?? '',
            'description_ar' => $this->getTranslations('description')['ar'] ?? '',

            'is_active' => $this->is_active,
            'status' => $this->status,

        ];
    }
}
