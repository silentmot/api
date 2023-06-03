<?php

namespace Afaqy\TripWorkflow\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\TripWorkflow\Rules\DateBiggerThanLastOperation;
use Afaqy\TripWorkflow\Rules\DeviceIpBelongToSameScaleZone;

class TakeCarWeightRequest extends FormRequest
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
                'required',
                'integer',
                'min:1',
                Rule::exists('trips', 'id')->where(function ($query) {
                    $query->whereNull('end_time');
                }),
            ],
            'plate_number' => [
                'sometimes',
                'nullable',
                'string',
                'min:5',
                Rule::exists('trips', 'plate_number')->where(function ($query) {
                    $query->where('id', request()->trip_id)->whereNull('end_time');
                }),
            ],
            'scale_ip'     => [
                'required',
                'ip',
                Rule::exists('scales', 'ip')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'device_ip'    => [
                'required',
                'ip',
                Rule::exists('devices', 'ip')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
                new DeviceIpBelongToSameScaleZone,
            ],
            'weight'       => ['required', 'integer', 'min:501'],
            'weight_time'  => ['required', 'date_format:"Y-m-d\TH:i:sP"', new DateBiggerThanLastOperation],
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
            'trip_id.exists'          => 'The selected trip id not found on our database.',
            'weight_time.date_format' => 'The weight time does not match ISO 8601 format, example: 2019-02-01T03:45:27+00:00.',
            'device_ip.exists'        => 'The selected device IP not found on our database.',
            'scale_ip.exists'         => 'The selected scale IP not found on our database.',
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
