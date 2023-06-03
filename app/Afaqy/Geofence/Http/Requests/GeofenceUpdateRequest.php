<?php

namespace Afaqy\Geofence\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class GeofenceUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => [
                'sometimes', 'required', 'string', 'min:3', 'max:50',
                Rule::unique('geofences', 'name')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'type'          => ['sometimes', 'required', 'string', 'min:3', 'max:50', 'in:zone,pit'],
            'geofence_id'   => [
                'required',
                'integer',
                'min:1',
                Rule::unique('geofences', 'geofence_id')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
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
            'name'          => 'المنطقة الجغرافية',
            'type'          => 'النوع',
            'geofence_id'   => 'ID',
        ];
    }
}
