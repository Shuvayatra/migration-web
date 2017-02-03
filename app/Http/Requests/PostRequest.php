<?php

namespace App\Http\Requests;


class PostRequest extends Request
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
            'metadata.title'                 => 'required',
            'metadata.status'                => 'required',
            'metadata.type'                  => 'required',
            'category_id'                    => 'required',
            'metadata.featured_image'        => 'sometimes|max:1024|image',
            'metadata.data.thumbnail'        => 'sometimes|max:1024',
            'metadata.data.file.*.file_name' => 'sometimes|mimes:pdf,doc,docx',
        ];
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'metadata.title.required'     => 'Title field is required.',
            'metadata.type.required'      => 'Post Type field is required.',
            'metadata.status.required'    => 'Post Status field is required.',
            'metadata.featured_image.max' => 'The Featured Image may not be greater than :max kilobytes.',
            'metadata.featured_image.mime' => 'Image file must be valid image file.',
            'category_id.required' => 'This field is required.'
        ];
    }
}
