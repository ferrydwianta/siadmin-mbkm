<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentLecturerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Lecturer');
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
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->student?->user),
            ],
            'password' => Rule::when($this->routeIs('lecturers.students.store'), [
                'required',
                'min:8',
                'max:255'
            ]),
            Rule::when($this->routeIs('lecturers.students.update'), [
                'nullable',
                'min:8',
                'max:255'
            ]),
            'student_number' => [
                'required',
                'numeric',
                'digits:9',
            ],
            'semester' => [
                'required',
                'integer'
            ],
            'batch' => [
                'required',
                'integer',
                'digits:4',
                'min:1901',
                'max:2155'
            ],
            'avatar' => [
                'nullable',
                'mimes:png,jpg,jpeg,webp',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'student_number' => 'Nomor Induk Mahasiswa',
            'semester' => 'Semester',
            'batch' => 'Angkatan',
            'avatar' => 'Photo',
        ];
    }
}
