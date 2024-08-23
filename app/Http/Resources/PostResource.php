<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource\BaseResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class PostResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $selectedLanguage = $request->input('table_language', 'en');

        return [
            'id' => $this->id,
            'user_id' => optional($this->user)->name,
            'image' => image_url($this->image),

            // 'title' => $this->title,
            'title' => $this->getTranslations('title')[$selectedLanguage] ?? '',
            'title_en' => $this->getTranslations('title')['en'] ?? '',
            'title_ar' => $this->getTranslations('title')['ar'] ?? '',

            // 'description' => $this->description,
            'description' => $this->getTranslations('description')[$selectedLanguage] ?? '',
            'description_en' => $this->getTranslations('description')['en'] ?? '',
            'description_ar' => $this->getTranslations('description')['ar'] ?? '',

            'is_active' => $this->is_active,
            'status' => $this->status,
        ];
    }
}
