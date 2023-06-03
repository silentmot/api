<?php

namespace Afaqy\Dashboard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StationsRerportsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from'       => ['required_with:to', 'date_format:Y-m-d', 'before_or_equal:to'],
            'to'         => ['required_with:from', 'date_format:Y-m-d', 'after_or_equal:from'],
            'type'       => ['sometimes', 'in:daily,weekly,monthly'],
            'stations'   => ['sometimes', 'array'],
            'stations.*' => ['sometimes', 'string'],
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
            'from'       => __('from'),
            'to'         => __('to'),
            'type'       => __('type'),
            'stations'   => __('stations'),
            'stations.*' => __('station'),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'from.date_format' => trans('dashboard::dashboard.date_format'),
            'to.date_format'   => trans('dashboard::dashboard.date_format'),
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
