<?php

namespace Afaqy\EntrancePermission\Http\Requests;

use Illuminate\Validation\Rule;
use Afaqy\User\Rules\SaudiMobilFormat;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Permission\Rules\NationalIDFormat;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveContract;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveEntrancePermission;
use Afaqy\EntrancePermission\Rules\UnitPlateNumberNotRelatedToActiveNormalPermission;

class EntrancePermissionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'            => ['required', 'in:employee,visitor'],
            'name'            => ['required', 'string', 'min:3', 'max:50'],
            'title'           => ['required', 'string', 'min:3', 'max:50'],
            'national_id'     => ['required', new NationalIDFormat, 'digits:10'],
            'phone'           => ['required', new  SaudiMobilFormat,
                Rule::unique('entrance_permissions', 'phone')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'start_date'     => ['required', 'date_format:d-m-Y'],
            'end_date'       => ['required', 'date_format:d-m-Y', 'after_or_equal:start_date'],
            'company'        => ['required_if:type,visitor', 'nullable', 'string', 'min:3', 'max:50'],
            'plate_number'   => [
                'required',
                'string',
                'min:4',
                'max:8',
                new UnitPlateNumberNotRelatedToActiveContract,
                new UnitPlateNumberNotRelatedToActiveEntrancePermission,
                new UnitPlateNumberNotRelatedToActiveNormalPermission,
            ],
            'rfid'           => [
                'nullable',
                'integer',
                Rule::unique('entrance_permissions', 'rfid')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('units', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                'unique:permit_units,rfid',
            ],
            'qr_code'         => [
                'nullable',
                'integer',
                Rule::unique('entrance_permissions', 'qr_code')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('units', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                'unique:permit_units,qr_code',
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

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'                   => ' الاسم',
            'type'                   => 'النوع',
            'title'                  => 'الصفة',
            'national_id'            => 'رقم الهويه',
            'phone'                  => 'رقم الجوال',
            'plate_number'           => 'اسم المركبة',
            'company'                => 'الشركة',
            'start_date'             => 'تاريخ البدء',
            'end_date'               => 'تاريخ الانتهاء',

        ];
    }
}
