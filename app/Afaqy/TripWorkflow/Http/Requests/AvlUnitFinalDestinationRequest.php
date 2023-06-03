<?php

namespace Afaqy\TripWorkflow\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AvlUnitFinalDestinationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'plate_number'     => [
                'required',
                'string',
                'min:4',
                'max:8',
                Rule::exists('units', 'plate_number')->where(function ($query) {
                    return $query->where('active', 1)->whereNull('deleted_at');
                }),
            ],
            'shift_id'         => ['required', 'integer', 'min:1'],
            'arrival_time'     => ['required', 'date_format:"Y-m-d\TH:i:sP"'],
            'arrival_location' => ['required', 'string', 'min:1'],
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
            'arrival_time.date_format' => 'The arrival time does not match ISO 8601 format, example: 2019-02-01T03:45:27+00:00.',
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
