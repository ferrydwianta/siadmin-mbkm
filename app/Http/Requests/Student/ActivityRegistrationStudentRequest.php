<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRegistrationStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Student');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // rules for courses conversion
            'conversions' => [
                'nullable', 
                'array'
            ],
            'conversions.*' => [
                'exists:courses,id'
            ], 
        ];
    }

    public function attributes(): array
    {
        return [
            'conversions' => 'Konversi Mata kuliah Diambil'
        ];
    }
}
