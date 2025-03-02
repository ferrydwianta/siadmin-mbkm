<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerStudentRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'description' => [
                'required',
                'string',
                'min:0',
            ],
            'logo' => [
                'nullable',
                'mimes:png, jpg, jpeg, webp',
                'max:2048',
            ],
            'address' => [
                'nullable',
                'string',
                'min:0',
                'max:255'
            ],
            'contact' => [
                'nullable',
                'regex:/^\+?[0-9]+$/', // Must be numbers and can start with +
                'min:0',
                'max:15'
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Mitra',
            'description' => 'Deskripsi',
            'logo' => 'Logo',
            'address' => 'Alamat Mitra',
            'contact' => 'Contact Person'
        ];
    }
}
