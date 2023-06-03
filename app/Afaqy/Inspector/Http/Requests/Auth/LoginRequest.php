<?php

namespace Afaqy\Inspector\Http\Requests\Auth;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'otp' => [
                'required',
                'integer',
                'digits:5',
                Rule::exists('mob_supervisor_otp', 'otp_code')->where(function ($query) {
                    $query->where('expires_at', '>', Carbon::now()->toDateTimeString());
                }),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'otp.exists' => trans('inspector::inspector.otp-not-exists'),
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
