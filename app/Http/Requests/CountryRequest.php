<?php

namespace App\Http\Requests;


class CountryRequest extends Request
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
            'name'  => 'required',
            'code'  => 'required',
            'image' => 'required|mimes:png,jpeg,png,bmp,gif,jpg',
        ];

        if ($this->isMethod('PATCH')) {
            unset($rules['image']);
        }

        return $rules;
    }
}
