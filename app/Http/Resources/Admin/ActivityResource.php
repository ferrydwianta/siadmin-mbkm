<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ActivityResource extends JsonResource
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
            'type' => $this->type,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'document' => $this->document ? Storage::url($this->document) : null,
            'partner' => $this->whenLoaded('partner', [
                'id' => $this->partner?->id,
                'name' => $this->partner?->name,
                'description' => $this->partner?->description,
                'logo' => $this->partner?->logo ? Storage::url($this->partner?->logo) : null,
            ]),
            'student' => $this->whenLoaded('student', [
                'id' => $this->student?->id,
                'name' => $this->student?->user->name,
                'student_number' => $this->student?->student_number,
            ]),
            'courses' => $this->whenLoaded('courses', fn() => $this->courses->map(fn($course) => [
                'id' => $course->id,
                'name' => $course->name,
            ])),
        ];
    }
}
