<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatThreadRequest extends FormRequest
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
            'painter_id' => 'required|exists:App\Painter,id',
            'message'    => 'required|string|max:2048',
        ];
    }
}
