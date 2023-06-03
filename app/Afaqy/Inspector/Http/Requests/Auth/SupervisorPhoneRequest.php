<?php

namespace Afaqy\Inspector\Http\Requests\Auth;

use Afaqy\User\Rules\SaudiMobilFormat;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Inspector\Rules\PhoneBelongToContractSupervisor;

class SupervisorPhoneRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => [
                'required',
                new SaudiMobilFormat,
                new PhoneBelongToContractSupervisor,
            ],
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
