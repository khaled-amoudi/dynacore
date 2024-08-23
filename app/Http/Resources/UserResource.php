<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource\BaseResource;

class UserResource extends BaseResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_url' => image_url($this->profile_photo_url),

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
