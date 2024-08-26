<?php

namespace App\Http\Requests;


class CategoryRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'items_name_en' => 'required',
            // 'items.*.items_name_en' => 'required',
            // 'image' => [ 'image' , 'max:1024' , 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
