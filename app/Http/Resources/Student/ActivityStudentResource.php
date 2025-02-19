<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ActivityStudentResource extends JsonResource
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
            'description' => $this->description,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'partner' => $this->whenLoaded('partner', [
                'id' => $this->partner?->id,
                'name' => $this->partner?->name,
                'description' => $this->partner?->description,
                'address' => $this->partner?->address,
                'contact' => $this->partner?->contact,
                'logo' => $this->partner?->logo ? Storage::url($this->partner?->logo) : null,
            ]),
            'courses' => $this->whenLoaded('courses', fn() => $this->courses->map(fn($course) => [
                'id' => $course->id,
                'name' => $course->name,
            ])),
        ];
    }
}
