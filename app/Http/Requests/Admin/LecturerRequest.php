<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LecturerRequest extends FormRequest
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
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->lecturer?->user),
            ],
            'password' => Rule::when($this->routeIs('admin.lecturers.store'), [
                'required',
                'min:8',
                'max:255'
            ]),
            Rule::when($this->routeIs('admin.lecturers.update'), [
                'null',
                'min:8',
                'max:255'
            ]),
            'lecturer_number' => [
                'required',
                'numeric',
                'digits_between:1,20',
            ],
            'academic_title' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'avatar' => [
                'nullable',
                'mimes:png,jpg,jpeg,webp'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'lecturer_number' => 'Nomor Induk Dosen',
            'academic_title' => 'Jabatan Akademik',
            'avatar' => 'Avatar'
        ];
    }
}
