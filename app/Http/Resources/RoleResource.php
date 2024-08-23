<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource\BaseResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class RoleResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $selectedLanguage = $request->input('table_language', 'en');

        return [
            'id' => $this->id,
            'name' => $this->name,

        ];
    }
}
