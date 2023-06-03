<?php

namespace Afaqy\Activity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'     => ['nullable', 'string'],
            'sort'         => ['nullable', 'string'],
            'direction'    => ['nullable', 'string', 'in:asc,desc'],
            'per_page'     => ['sometimes', 'integer', 'min:20'],
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
