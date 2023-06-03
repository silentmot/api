<?php

namespace Afaqy\Permission\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Afaqy\Permission\Models\PermitUnit;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveContract;
use Afaqy\Permission\Rules\UnitPlateNumberNotRelatedToActiveEntrancePermission;

class UpdatePermissionUnitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $old_qr   = last(explode('/', request()->path()));
        $old_unit = PermitUnit::where('qr_code', $old_qr)->firstOrFail();

        return [
            'plate_number' => [
                'required',
                'string',
                'min:4',
                'max:8',
                new UnitPlateNumberNotRelatedToActiveContract,
                new UnitPlateNumberNotRelatedToActiveEntrancePermission,
            ],
            'rfid'         => [
                'nullable',
                'integer',
                Rule::unique('permit_units', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                })->ignore($old_unit->rfid, 'rfid'),
                Rule::unique('units', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('entrance_permissions', 'rfid')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'qr_code'      => [
                'required',
                'integer',
                Rule::unique('permit_units', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                })->ignore($old_unit->qr_code, 'qr_code'),
                Rule::unique('units', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
                Rule::unique('entrance_permissions', 'qr_code')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                }),
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
