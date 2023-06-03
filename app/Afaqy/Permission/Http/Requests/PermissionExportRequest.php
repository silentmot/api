<?php

namespace Afaqy\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionExportRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort'      => ['sometimes', 'string', 'in:permission_number,type,allowed_weight,actual_weight'],
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
