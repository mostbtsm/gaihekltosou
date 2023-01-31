<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExampleRequest extends FormRequest
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
        $max_size = config('const.image.max_size');

        return [
            'title'               => 'required|string|max:256',
            'address'             => 'nullable|string|max:256',
            'category'            => 'nullable|array',
            'property_type'       => 'nullable|numeric',
            'amount'              => 'nullable|numeric',
            'period'              => 'nullable|numeric',
            'warranty_value1'     => 'nullable|numeric',
            'warranty_value2'     => 'nullable|numeric',
            'warranty_value3'     => 'nullable|numeric',
            'warranty_value4'     => 'nullable|numeric',
            'warranty_name5'      => 'nullable|string|max:48',
            'warranty_value5'     => 'nullable|numeric',
            'complete_date_year'  => 'nullable|numeric',
            'complete_date_month' => 'nullable|numeric|min:1|max:12',
            'image_file1'         => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'image_file2'         => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'image_file3'         => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'image_file4'         => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'image_file5'         => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'image_file6'         => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'comment'             => 'nullable|string',
            'public_consent'      => 'nullable|boolean',
        ];
    }
}
