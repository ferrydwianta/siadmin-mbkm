<?php

namespace App\Http\Requests\Admin;

use App\Enums\ScheduleDay;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ScheduleRequest extends FormRequest
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
            'start_time' => [
                'required'
            ],
            'end_time' => [
                'required'
            ],
            'date' => [
                'required',
                'date',
            ],
            'selected_registrations' => [
                'array',
                Rule::when($this->routeIs('admin.schedules.store'), [
                    'required',
                ]),
                Rule::when($this->routeIs('admin.schedules.update'), [
                    'nullable',
                ]),
            ],
            'selected_registrations.*' => [
                'exists:activity_registrations,id'
            ], 
        ];
    }

    public function attributes(): array
    {
        return [
            'start_time' => 'Waktu Mulai',
            'end_time' => 'Waktu Berakhir',
            'date' => 'Hari',
            'selected_registrations' => 'Mahasiswa'
        ];
    }
}
