<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRegistrationGradesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'conversions' => ['required', 'array', 'min:1'],
            'conversions.*.id' => ['required', 'integer', 'exists:conversions,id'],
            'conversions.*.grade' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'conversions' => 'Konversi SKS',
            'conversions.*.id' => 'Konversi ID',
            'conversions.*.grade' => 'Nilai Konversi',
        ];
    }
}
