<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StadiumRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:2'],
            'firm_id' => ['required', Rule::exists('firms', 'id')],
            'opening_time' => ['required'],
            'closing_time' => ['required'],
            'daytime_start' => ['required'],
            'nighttime_start' => ['required'],
            'nighttime_end' => ['required'],
            'daytime_price' => ['required'],
            'nighttime_price' => ['required'],
        ];
    }
}
