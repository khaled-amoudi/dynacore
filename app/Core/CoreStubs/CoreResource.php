<?php

namespace App\Core\CoreStubs;

use App\Http\Resources\BaseResource\BaseResource;

class CoreResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // // in case of translatable columns
        // $selectedLanguage = $request->input('table_language', 'en');


        return [
            // 'id' => $this->id,
            // // relation
            // 'user_id' => optional($this->user)->name,
            // // image
            // 'image' => image_url($this->image),

            // // translatable
            // 'title' => $this->getTranslations('title')[$selectedLanguage] ?? '',
            // 'title_en' => $this->getTranslations('title')['en'] ?? '',
            // 'title_ar' => $this->getTranslations('title')['ar'] ?? '',
        ];
    }
}
