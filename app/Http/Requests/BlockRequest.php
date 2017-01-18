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
        }

        return $rules;
    }
}
