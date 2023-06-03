<?php

namespace Afaqy\Gate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GateExportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort'      => ['sometimes', 'string', 'in:name,serial,direction'],
            'direction' => ['sometimes', 'string', 'in:desc,asc'],
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
