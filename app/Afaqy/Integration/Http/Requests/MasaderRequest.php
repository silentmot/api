<?php

namespace Afaqy\Integration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasaderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date'   => ['sometimes', 'date_format:"Y-m-d"'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date.date_format' => 'The date does not match date format, example: 2019-02-01.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
