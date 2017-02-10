<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ScreenRequest extends Request
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
            'name'                  => 'required|unique:screens,name',
            'slug'                  => ['required','unique:screens,slug','regex:/^[a-zA-Z0-9|-]+$/'],
            'title'                 => 'required',
            'type'                  => 'required',
            'visibility.country_id' => 'required',
        ];
        if ($this->isMethod("patch")) {
            unset($rules['type']);
            $rules['name'] = 'required|unique:screens,name,'.$this->segment(2);
            $rules['slug'] = 'required|unique:screens,slug,'.$this->segment(2);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'                  => 'Name is required',
            'title.required'                 => 'Title is required',
            'type.required'                  => 'Type is required',
            'visibility.country_id.required' => 'Visibility Country is required',
        ];
    }
}
