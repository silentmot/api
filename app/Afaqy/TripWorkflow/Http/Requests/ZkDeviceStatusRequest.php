<?php

namespace Afaqy\TripWorkflow\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZkDeviceStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_action'      => ['required', 'in:OPEN,CLOSE'],
            'event_description' => ['required', 'string'],
            'create_date'       => ['required', 'date_format:"Y-m-d\TH:i:sP"'],
            'device_type'       => ['required', 'in:LRP,RFID,QR Code'],
            'device_ip'         => ['required', 'ip'],
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
            'event_action.in'            => 'The selected event action is invalid, Choose between OPEN or CLOSE.',
            'create_date.date_format'    => 'The create date does not match ISO 8601 format, example: 2019-02-01T03:45:27+00:00.',
            'device_type.in'             => 'The selected device type is invalid, Choose between LRP, RFID or QR Code.',
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
