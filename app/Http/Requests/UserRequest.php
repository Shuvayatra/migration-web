<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'role'     => 'required',
            'password' => 'required'
        ];

        if ($this->isMethod('PATCH')) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->get('id');
            if (empty($this->get('password'))) {
                unset($rules['password']);
            }
        }

        return $rules;
    }
}
