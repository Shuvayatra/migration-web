<?php

namespace App\Http\Requests;


class BlockRequest extends Request
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
            'metadata.layout' => 'required',
        ];
        if (in_array($this->get('metadata')['layout'], ['slider', 'list'])) {
            $rules = $rules + ['metadata.title' => 'required'];
            $rules = $rules + ['metadata.category_id' => 'required'];
            $rules = $rules + ['metadata.country.type' => 'required'];
        }

        return $rules;
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'metadata.layout.required'      => 'Layout is required.',
            'metadata.title.required'       => 'Title is required.',
            'metadata.category_id.required' => 'Category field is required.',
            'metadata.country.type.required'=> 'Country type filed is required',
        ];
    }
}
