<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('Admin'); // Already logged in and role is admin
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
                // 'max:5000'
            ],
            'logo' => Rule::when($this->routeIs('admin.partners.store'), [
                'required',
                'mimes:png, jpg, jpeg, webp',
                'max:2048',
            ]),
            Rule::when($this->routeIs('admin.partners.update'), [
                'nullable',
                'mimes:png, jpg, jpeg, webp',
                'max:2048',
            ]),
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'description' => 'Description',
            'logo' => 'Logo',
        ];
    }
}
