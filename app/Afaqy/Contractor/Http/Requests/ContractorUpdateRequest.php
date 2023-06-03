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

class ContractorUpdateRequest extends FormRequest
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
                'sometimes', 'required', 'string',
                'min:3', 'max:50', new ArabicCharacters,
                Rule::unique('contractors', 'name_ar')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'name_en'          => [  'sometimes', 'required', 'string',
                'min:3', 'max:50', new EnglishCharacters,
                Rule::unique('contractors', 'name_en')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'commercial_number'  => ['nullable',
                Rule::unique('contractors', 'commercial_number')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
                new TenDigitsNotStartedWithZero,
            ],
            'address'            => ['nullable','string',
                'min:10', 'max:100',
            ],
            'employees'          => ['nullable', 'numeric', 'gt:0'],
            'avl_company'        => ['nullable', 'string', 'in:machine,vision,alqimma'],
            'contacts'           => ['sometimes', 'required', 'array'],
            'contacts.*'         => ['sometimes', 'required', 'array'],
            'contacts.*.name'    => ['sometimes', 'required', 'string', 'min:3', 'max:50',
            ],
            'contacts.*.title'   => ['nullable', 'string',
                'min:3', 'max:50',
            ],
            'contacts.*.email'   => ['nullable' , new EmailFormat],
            'contacts.*.phones'  => ['sometimes', 'required', 'array', 'max:2'],
            'contacts.*.phones.*'=> [ 'required',
                'digits:10', new SaudiMobilFormat,
            ],
            'contacts.*.default_contact' => ['sometimes', new CheckSingleDefaultContact, 'nullable', 'boolean'],
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
            'name_ar'             => 'اسم المقاول باللغة العربية',
            'name_en'             => 'اسم المقاول باللغة الانجليزية',
            'commercial_number'   => 'رقم السجل التجارى ',
            'employees'           => 'العمالة',
            'address'             => 'العنوان',
            'contacts'            => 'المسئولين',
            'contacts.*'          => 'المسئول',
            'contacts.*.name'     => 'اسم المسئول',
            'contacts.*.title'    => 'صفة المسئول',
            'contacts.*.email'    => 'البريد الالكترونى',
            'contacts.*.phones'   => 'التليفون',
            'contacts.*.phones.*' => 'التليفون',
        ];
    }
}
