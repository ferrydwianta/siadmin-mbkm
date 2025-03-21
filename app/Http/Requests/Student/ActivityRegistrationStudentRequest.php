<?php

namespace App\Http\Requests\Student;

use App\Models\Course;
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
        $rules = [
            'conversions' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    $totalCredits = Course::whereIn('id', $value)->sum('credit');
                    if ($totalCredits > 20) {
                        $fail('Total SKS tidak boleh melebihi 20 SKS.');
                    }
                },
            ],
            'conversions.*' => ['exists:courses,id'],
            'member_type' => ['required', 'string'],
        ];

        if ($this->isMethod('put')) {
            $rules = [
                'document' => [
                    'required',
                    'mimes:pdf,docx,doc',
                    'max:3072',
                ]
            ];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'conversions' => 'Konversi Mata kuliah Diambil',
            'member_type' => 'Jenis Anggota',
            'document' => 'Dokumen Laporan Akhir'
        ];
    }
}
