<?php

namespace App\Http\Requests;


class PlaceRequest extends Request
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
            'metadata.title'       => 'required',
            'metadata.address'     => 'required',
            'metadata.description' => 'required',
            'image'                => 'required|image',
            'country_id'           => 'required',
            'status'               => 'required'
        ];

        if ($this->isMethod('PATCH')) {
            unset($rules['image']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'metadata.title.required'       => 'The title field is required.',
            'country_id.required'           => 'The country field is required.',
            'metadata.address.required'     => 'The address field id required.',
            'metadata.description.required' => 'The description field is required.',
        ];
    }
}
