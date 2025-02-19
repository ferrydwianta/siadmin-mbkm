<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
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
            'partner_id' => [
                'required',
                'exists:partners,id',
            ],
            'name' => [
                'required',
                'string',
                'min:3',
                'max: 255',
            ],
            'description' => [
                'required',
                'string',
                'min:0',
            ],

            // rules for courses conversion
            'courses' => [
                'nullable', 
                'array'
            ],
            'courses.*' => [
                'exists:courses,id'
            ], 
        ];
    }

    public function attributes(): array
    {
        return [
            'partner_id' => 'Mitra MBKM',
            'name' => 'Nama Kegiatan',
            'description' => 'Deskripsi',
            'courses' => 'Konversi Mata kuliah'
        ];
    }
}
