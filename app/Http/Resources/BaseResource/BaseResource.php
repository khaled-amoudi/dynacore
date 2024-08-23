<?php

namespace App\Http\Resources\BaseResource;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    // return [
    //     'secret' => $this->when($request->user()->isAdmin(), 'secret-value'),

    //     'secret' => $this->when($request->user()->isAdmin(), function () {
    //         return 'secret-value';
    //     }),

    //     'name' => $this->whenNotNull($this->name),

    //     'name' => $this->whenHas('name'),

    //     $this->mergeWhen($request->user()->isAdmin(), [
    //         'first-secret' => 'value',
    //         'second-secret' => 'value',
    //     ]),

    //     'posts' => PostResource::collection($this->whenLoaded('posts')),
    // ];



    /**
     * @auther 5vld
     * this method used to get the data of translatable column depending on the switch language in the datatable
     * use: pass the attribute name as a parameter e.g. $this->translation('description')
     */
    public function translation($attr) {
        return $this->getTranslations($attr)[request()->input('table_language', 'en')] ?? '';
    }
}
