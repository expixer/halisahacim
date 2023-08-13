<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStadium extends FormRequest
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
            'a' => 'required',
            'b' => 'required',
            'c' => ['required', Rule::when(request()->routeIs('stadium.store'), 'sometimes')],
            'email' => ['required', Rule::unique('users')->ignore($this->user->id)],
        ];
    }
}
