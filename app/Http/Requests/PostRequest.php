<?php

namespace App\Http\Requests;


class PostRequest
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
            // 'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
