<?php

namespace Afaqy\Permission\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Permission\Rules\CheckRfidDuplication;
use Afaqy\Permission\Rules\CheckQrCodeDuplication;
use Afaqy\Permission\Rules\CheckPlateNumberDuplication;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveContract;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveEntrancePermission;

class PermissionAppendUnitsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'units'                    => ['sometimes', 'required', 'array'],
            'units.*'                  => ['sometimes', 'required', 'array'],
            'units.*.plate_number'     => [
                'required',
                'string',
                'min:4',
                'max:8',
                new UnitPlateNumberNotRelatedToActiveContract,
                new CheckPlateNumberDuplication,
                new UnitPlateNumberNotRelatedToActiveEntrancePermission,
            ],
            'units.*.rfid'             => [
                'nullable',
                'integer',
                Rule::unique('permit_units', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('units', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('entrance_permissions', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                new CheckRfidDuplication,
            ],
            'units.*.qr_code'           => [
                'nullable',
                'integer',
                Rule::unique('permit_units', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('units', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('entrance_permissions', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                new CheckQrCodeDuplication,
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
            'units.*'                => 'المركبات',
            'units.*.plate_number'   => 'اسم المركبة',
            'units.*.rfid'           => 'RFID',
            'units.*.qr_code'        => 'QR Code',
        ];
    }
}
