<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSliderUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title_1' => 'nullable|max:255',
            'title_2' => 'nullable|max:255',
            'button_title' => 'nullable|max:255',
            'button_link' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }
}
