<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class PainterEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('painter')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $max_size = config('const.image.max_size');
        $painter = Auth::guard('painter')->user();

        return [
            'email'                => ['required', 'email', 'max:256', Rule::unique('painters')->ignore($painter->id)],
            'name'                 => 'required|string|max:256',
            'kana'                 => 'nullable|string|max:256',
            'ceo_name'             => 'nullable|string|max:256',
            'type'                 => 'nullable|string|max:256',
            'postal'               => 'nullable|string|max:8',
            'prefectures'          => 'nullable|numeric',
            'city'                 => 'nullable|string|max:20',
            'address1'             => 'nullable|string|max:256',
            'address2'             => 'nullable|string|max:256',
            'tel'                  => 'nullable|string|max:20',
            'fax'                  => 'nullable|string|max:20',
            'charge_name1'         => 'nullable|string|max:48',
            'charge_name2'         => 'nullable|string|max:48',
            'charge_kana1'         => 'nullable|string|max:48',
            'charge_kana2'         => 'nullable|string|max:48',
            'charge_tel'           => 'nullable|string|max:20',
            'charge_email'         => 'nullable|email|max:256',
            'url'                  => 'nullable|url|max:256',
            'established'          => 'nullable|numeric|max:9999',
            'capital'              => 'nullable|numeric|max:99999999', // 万円単位
            'permission'           => 'nullable|string|max:256',
            'organization'         => 'nullable|string|max:256',
            'sales'                => 'nullable|numeric',
            'employees'            => 'nullable|numeric|max:99999',
            'social_insurance'     => 'nullable|boolean',
            'accident_insurance'   => 'nullable|boolean',
            'other_insurance'      => 'nullable|string|max:128',
            'catch_copy'           => 'nullable|string|max:256',
            'constructions'        => 'nullable|numeric|max:999999',
            'annual_constructions' => 'nullable|numeric|max:999999',
            'pr_copy'              => 'nullable|string|max:256',
            'image_file'           => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'image_file1'          => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'image_file2'          => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'image_file3'          => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
            'image_file4'          => "nullable|file|image|max:{$max_size}|mimes:jpg,jpeg,gif,png",
        ];
    }
}
