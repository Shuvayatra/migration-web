<?php

namespace App\Http\Requests;


class JourneyRequest extends Request
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
        $rules = [
            'title'            => 'required',
            'menu_image'       => 'required|image',
            'featured_image'   => 'required|image',
            'small_menu_image' => 'required|image'
        ];

        if ($this->isMethod('PATCH')) {
            unset($rules['menu_image']);
            unset($rules['featured_image']);
            unset($rules['small_menu_image']);
        }

        return $rules;
    }
}
