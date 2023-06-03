<?php

namespace Afaqy\Permission\Http\Requests\Sorting;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Permission\Rules\NationalIDFormat;
use Afaqy\Permission\Rules\CheckRfidDuplication;
use Afaqy\Permission\Rules\CheckQrCodeDuplication;
use Afaqy\Permission\Rules\CheckPlateNumberDuplication;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveContract;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveEntrancePermission;

class SortingAreaPermissionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'waste_type_id'  => [
                'required',
                'integer',
                Rule::exists('waste_types', 'id')->where(function ($query) {
                    $query->whereNotIn('id', [1, 2, 3, 4]);
                }),
            ],
            'allowed_weight'            => ['nullable', 'integer', 'gt:0'],
            'entity_name'               => ['required', 'string', 'min:3', 'max:50'],
            'representative_name'       => ['nullable', 'string', 'min:3', 'max:50'],
            'national_id'               => ['nullable', new NationalIDFormat, 'digits:10'],
            'units'                     => ['required', 'array', 'size:1'],
            'units.*'                   => ['required', 'array'],
            'units.*.plate_number'      => [
                'required',
                'string',
                'min:4',
                'max:8',
                new UnitPlateNumberNotRelatedToActiveContract,
                new UnitPlateNumberNotRelatedToActiveEntrancePermission,
                new CheckPlateNumberDuplication,
            ],
            'units.*.rfid'              => [
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
            'waste_type_id'             => __('waste type'),
            'entity_name'               => __('entity name'),
            'representative_name'       => __('representative_name'),
            'national_id'               => __('national id'),
            'allowed_weight'            => __('allowed weight'),
            'units.*'                   => __('units'),
            'units.*.plate_number'      => __('plate number'),
            'units.*.rfid'              => __('rfid'),
            'units.*.qr_code'           => __('QR Code'),
        ];
    }
}
