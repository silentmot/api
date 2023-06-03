<?php

namespace Afaqy\TransitionalStation\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class TransitionalStationUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                Rule::unique('transitional_stations', 'name')->where(function (Builder $query) {
                    return $query->whereNull('deleted_at');
                })->ignore($this->route('id')),
            ],
            'districts'     => [ 'required', 'array'],
            'districts.*'   => [
                'required',
                'integer',
                Rule::exists('districts', 'id')->where(function ($query) {
                    return $query->whereNull('deleted_at')->where('status', 1);
                }),
            ],
            'status' => ['required', 'boolean'],
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
            'name'        => __('name'),
            'status'      => __('status'),
            'districts'   => __('districts'),
            'districts.*' => __('district'),
        ];
    }
}
