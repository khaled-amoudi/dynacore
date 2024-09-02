<?php

namespace App\Core\CoreStubs;


class CoreRequest
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
            // 'title' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // 'title.required' => __('title is required'),
        ];
    }

    public function attributes()
    {
        return [
            // 'name_en' => __('name_en'),
            // 'name_ar' => __('name_ar'),
        ];
    }
}
