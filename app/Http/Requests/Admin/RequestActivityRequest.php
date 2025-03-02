<?php

namespace App\Http\Requests\Admin;

use App\Enums\StudentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RequestActivityRequest extends FormRequest
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
            'status' => [
                'required',
                new Enum(StudentStatus::class),
            ],
            'courses' => [
                'nullable',
                'array',
            ],
            'courses.*' => [
                'exists:courses,id'
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'status' => 'Status',
            'courses' => 'Konversi Mata kuliah'
        ];
    }
}
