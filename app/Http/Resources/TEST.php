<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource\BaseResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class TEST extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = $this->toArrayMain();

        if (Str::contains($this->currentRoute(), 'index')) {
            $data = array_merge($data, $this->toIndex());
        } elseif (Str::contains($this->currentRoute(), 'create')) {
            $data = array_merge($data, $this->toCreate());
        } elseif (Str::contains($this->currentRoute(), 'edit')) {
            $data = array_merge($data, $this->toEdit());
        } elseif (Str::contains($this->currentRoute(), 'show')) {
            $data = array_merge($data, $this->toShow());
        } else {
            $data = $data;
        }

        return $data;
    }



    protected function toArrayMain()
    {
        return [
            'id' => $this->id,
            // // relation
            'category_id' => optional($this->category)->name,
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
            'kkkkkkkkkkkkkkkkkkkkkkkkkkkk' => 'sssssssssssssssssssssss',

        ];
    }
    protected function toIndex()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rrrrrrrrrrrrrrrrrr' => 'kkkkkkkkkkkkkkkkkkkkkkkkkkkk',
        ];
    }

    protected function toCreate()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rrrrrrrrrrrrrrrrrr' => 'kkkkkkkkkkkkkkkkkkkkkkkkkkkk',
        ];
    }

    protected function toEdit()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    protected function toShow()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }




    public function translation($attr)
    {
        return $this->getTranslations($attr)[request()->input('table_language', 'en')] ?? '';
    }
    public function currentRoute()
    {
        return Route::currentRouteName();
    }
}
