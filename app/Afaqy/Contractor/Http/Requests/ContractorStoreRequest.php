<?php

namespace Afaqy\Contractor\Http\Requests;

use Illuminate\Validation\Rule;
use Afaqy\User\Rules\SaudiMobilFormat;
use Illuminate\Database\Query\Builder;
use Afaqy\Contractor\Rules\EmailFormat;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Contractor\Rules\ArabicCharacters;
use Afaqy\Contractor\Rules\EnglishCharacters;
use Afaqy\Contractor\Rules\CheckSingleDefaultContact;
use Afaqy\Contractor\Rules\TenDigitsNotStartedWithZero;

class ContractorStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar'          => [
                'required',
                'string',
                'min:3',
                'max:50',
                new ArabicCharacters,
                Rule::unique('contractors', 'name_ar')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'name_en'          => ['required', 'string',
                'min:3', 'max:50', new EnglishCharacters,
                Rule::unique('contractors', 'name_en')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'commercial_number'  => ['nullable',
                new TenDigitsNotStartedWithZero,
                Rule::unique('contractors', 'commercial_number')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'address'            => ['nullable','string',
                'min:10', 'max:100',
            ],
            'employees'          => ['nullable', 'integer', 'gt:0'],
            'avl_company'        => ['nullable', 'string', 'in:machine,vision,alqimma'],
            'contacts'           => ['required', 'array'],
            'contacts.*'         => ['required', 'array'],
            'contacts.*.name'    => ['required', 'string',
                'min:3', 'max:50',
            ],
            'contacts.*.title'   => ['nullable' ,'string',
                'min:3', 'max:50',
            ],
            'contacts.*.email'   => ['nullable' , new EmailFormat],
            'contacts.*.phones'  => ['required', 'array', 'max:2'],
            'contacts.*.phones.*'=> [
                'required',
                'digits:10',
                new SaudiMobilFormat,
            ],
            'contacts.*.default_contact' => ['sometimes',new CheckSingleDefaultContact, 'nullable', 'boolean'],
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

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name_ar'             => __('Arabic name'),
            'name_en'             => __('English name'),
            'commercial_number'   => __('commercial number'),
            'employees'           => __('employees'),
            'address'             => __('address'),
            'contacts'            => __('contacts'),
            'contacts.*'          => __('contact'),
            'contacts.*.name'     => __('contact name'),
            'contacts.*.title'    => __('contact title'),
            'contacts.*.email'    => __('contact email'),
            'contacts.*.phones'   => __('contact phones'),
            'contacts.*.phones.*' => __('contact phone'),
        ];
    }
}
