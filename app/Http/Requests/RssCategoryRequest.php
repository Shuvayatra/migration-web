<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RssCategoryRequest extends Request
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
        if ($this->method == "PATCH") {
            return ['title' => 'required', 'image' => 'image'];
        }

        return [
            'title' => 'required',
            'image' => 'required|image',
        ];
    }

}
