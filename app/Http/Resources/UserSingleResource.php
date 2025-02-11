<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar ? Storage::url($this->avatar) : null,
            'roles' => $this->getRoleNames(),
            'role_name' => $this->getRoleNames()->first(),
            'student' => $this->when($this->hasRole('Student'), [
                'id' => $this->student?->id,
                'student_number' => $this->student?->student_number,
                'batch' => $this->student?->batch,
                'semester' => $this->student?->semester,
                'activity' => [
                    'id' => $this->student?->activity?->id,
                    'name' => $this->student?->activity?->name,
                ],
            ]),
            'lecturer' => $this->when($this->hasRole('Lecturer'), [
                'id' => $this->lecturer?->id,
                'lecturer_number' => $this->lecturer?->lecturer_number,
                'academic_title' => $this->lecturer?->academic_title,
            ]),
        ];
    }
}
