<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PushNotificationRequest extends Request
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
            'title'       => 'required',
            'description' => 'required',
//            'type'        => 'required',
//            'content_id'  => 'required|integer'
        ];
        if ($this->get('type') === 'post') {
           // $rules['content_id'] = 'required|integer|exists:posts,id';
        }

        return $rules;
    }
}
