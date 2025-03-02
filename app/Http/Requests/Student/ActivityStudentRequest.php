<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ActivityStudentRequest extends FormRequest
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
            'partner_id' => [
                'required',
                'exists:partners,id',
            ],
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'min:0',
            ],
            'type' => [
                'required',
                'string',
                'min:0',
                'max:255',
            ],
            'document' => [
                'nullable',
                'mimes:pdf,docx,doc',
                'max:3072',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'partner_id' => 'Mitra MBKM',
            'name' => 'Judul Kegiatan',
            'description' => 'Deskripsi',
            'type' => 'Jenis Kegiatan',
            'document' => 'Dokumen Pendukung'
        ];
    }
}
