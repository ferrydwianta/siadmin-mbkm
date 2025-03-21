<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'credit' => [
                'required',
                'integer',
            ],
            'semester' => [
                'nullable',
                'integer'
            ],
            'code' => [
                'required',
                'string',
                'min:2',
                'max:50',
            ],
            'is_open' => [
                'nullable',
                'boolean'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'credit' => 'Satuan Kredit Semester (SKS)',
            'semester' => 'Semester',
            'code' => 'Kode Mata Kuliah',
            'is_open' => 'Apakah Open Semester'
        ];
    }
}
