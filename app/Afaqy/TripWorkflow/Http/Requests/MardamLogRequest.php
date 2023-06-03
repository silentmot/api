<?php

namespace Afaqy\TripWorkflow\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MardamLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'plate_number'   => ['required', 'string', 'min:6'],
            'total_weight'   => ['required', 'integer', 'min:1'],
            'create_date'    => ['required', 'date_format:"Y-m-d\TH:i:sP"'],
            'operation_type' => ['required', 'in:in,out'],
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
            'create_date.date_format' => 'The create date does not match ISO 8601 format, example: 2019-02-01T03:45:27+00:00.',
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
