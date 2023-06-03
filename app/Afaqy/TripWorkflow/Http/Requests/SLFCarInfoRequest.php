<?php

namespace Afaqy\TripWorkflow\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SLFCarInfoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'car_number'         => ['required_if:device_type,LPR', 'nullable', 'string', 'min:4'],
            'card_number'        => ['required_if:device_type,RFID', 'nullable', 'integer'],
            'qr_number'          => ['required_if:device_type,QR', 'nullable', 'integer'],
            'create_date'        => ['sometimes', 'date_format:"Y-m-d\TH:i:sP"'],
            'client_create_date' => ['required', 'date_format:"Y-m-d\TH:i:sP"'],
            'photo_path'         => ['sometimes', 'nullable', 'string'],
            'channel_id'         => ['sometimes', 'nullable', 'integer'],
            'channel_name'       => ['sometimes', 'nullable', 'string'],
            'device_type'        => ['required', 'in:LPR,RFID,QR'],
            'device_ip'          => ['required', 'ip', 'exists:devices,ip'],
            'is_authorized'      => ['sometimes', 'nullable', 'boolean'],
            'direction'          => ['sometimes', 'nullable', 'in:IN,OUT'],
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
            'car_number.required'            => 'You must enter at least one of car_number, card_number or qr_number.',
            'card_number.required'           => 'You must enter at least one of car_number, card_number or qr_number.',
            'qr_number.required'             => 'You must enter at least one of car_number, card_number or qr_number.',
            'create_date.date_format'        => 'The create date does not match ISO 8601 format, example: 2019-02-01T03:45:27+00:00.',
            'client_create_date.date_format' => 'The client create date does not match ISO 8601 format, example: 2019-02-01T03:45:27+00:00.',
            'device_type.in'                 => 'The selected device type is invalid, Choose between LRP, RFID or QR Code.',
            'direction.in'                   => 'The selected direction is invalid, Choose between IN or OUT.',
            'device_ip.exists'               => 'Given device IP not registered!',
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
