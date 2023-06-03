<?php

namespace Afaqy\TripWorkflow\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GateInfoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trip_id'      => [
                Rule::requiredIf(function () {
                    return request()->plate_number == null;
                }),
                'nullable',
                'integer',
            ],
            'plate_number' => [
                Rule::requiredIf(function () {
                    return request()->trip_id == null;
                }),
                'nullable',
                'string',
                'min:5',
            ],
            'gate_ip'         => ['required', 'ip'],
            'gate_time'       => ['required', 'date_format:"Y-m-d\TH:i:sP"'],
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
            'trip_id.required'      => 'You must enter at least one of trip_id or plate_number.',
            'plate_number.required' => 'You must enter at least one of trip_id or plate_number.',
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
