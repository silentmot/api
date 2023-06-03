<?php

namespace Afaqy\District\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Afaqy\District\Rules\CheckNeighborhoodDuplication;
use Afaqy\District\Rules\CheckSubNeighborhoodDuplication;

class DistrictStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                                    => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('districts', 'name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'status'                                  => ['required', 'boolean'],
            'points.lat'                              => ['required', 'numeric'],
            'points.lng'                              => ['required', 'numeric'],
            'points.zoom'                             => ['required', 'integer'],
            'neighborhoods'                           => ['required', 'array'],
            'neighborhoods.*.name'                    => [
                'bail',
                'required',
                'string',
                'min:3',
                'max:50',
                new CheckNeighborhoodDuplication,
            ],
            'neighborhoods.*.population'              => ['nullable', 'integer', 'gt:0'],
            'neighborhoods.*.neighborhood_points.lat' => ['required', 'numeric'],
            'neighborhoods.*.neighborhood_points.lng' => ['required', 'numeric'],
            'neighborhoods.*.sub_neighborhoods'       => [
                'nullable',
                'array',
                new CheckSubNeighborhoodDuplication,
            ],
            'neighborhoods.*.sub_neighborhoods.*'     => [
                'string',
                'min:3',
                'max:50',
            ],
            'neighborhoods.*.status'                  => ['required', 'boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'                                    => 'المنطقة',
            'points'                                  => 'موقع المنطقة',
            'points.lat'                              => 'خط العرض',
            'points.lng'                              => 'خط الطول',
            'points.zoom'                             => 'مستوي العمق',
            'neighborhoods'                           => 'الاحياء',
            'neighborhoods.*.id'                      => 'معرف الحي',
            'neighborhoods.*.name'                    => 'الحي',
            'neighborhoods.*.population'              => 'الكثافة السكانية',
            'neighborhoods.*.status'                  => 'الحالة',
            'neighborhoods.*.neighborhood_points'     => 'موقع الحي',
            'neighborhoods.*.neighborhood_points.lat' => 'خط العرض',
            'neighborhoods.*.neighborhood_points.lng' => 'خط الطول',
            'neighborhoods.*.sub_neighborhoods'       => 'الأحياء الفرعية',
            'neighborhoods.*.sub_neighborhoods.*'     => 'الحي الفرعي',
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
