<?php

namespace Afaqy\Contract\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'   => ['sometimes', 'string', 'min:1'],
            'sort'      => ['sometimes', 'string', 'in:id,contract_number,start_at,end_at,contractor_name_ar,units_count,districts_count,contact_name'],
            'direction' => ['sometimes', 'string', 'in:desc,asc'],
            'per_page'  => ['sometimes', 'integer', 'min:10', 'max:200'],
            'all_pages' => ['sometimes', 'nullable', 'boolean'],
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
