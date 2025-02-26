<?php

namespace App\Http\Requests\Admin;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

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

            // rules for courses conversion
            'courses' => [
                'nullable',
                'array',
                // function ($attribute, $value, $fail) {
                //     $totalCredits = Course::whereIn('id', $value)->sum('credit');
                //     if ($totalCredits > 20) {
                //         $fail('Total SKS tidak boleh melebihi 20 SKS.');
                //     }
                // },
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
            'name' => 'Judul Kegiatan',
            'description' => 'Deskripsi',
            'type' => 'Jenis Kegiatan',
            'courses' => 'Konversi Mata kuliah'
        ];
    }
}
