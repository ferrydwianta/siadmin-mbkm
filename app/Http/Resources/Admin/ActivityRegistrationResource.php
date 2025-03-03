<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ActivityRegistrationResource extends JsonResource
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'notes' => $this->notes,
            'memberType' => $this->member_type,
            'academicYear' => $this->whenLoaded('academicYear', [
                'id' => $this->academicYear?->id,
                'name' => $this->academicYear?->name,
                'semester' => $this->academicYear?->semester,
            ]),
            'document' => $this->document ? Storage::url($this->document) : null,
            'student' => new StudentResource($this->whenLoaded('student')),
            'schedule' => new ScheduleResource($this->whenLoaded('schedule')),
            'activity' => new ActivityResource($this->whenLoaded('activity')),
            'conversions' => $this->whenLoaded('conversions', fn() => 
                $this->conversions->map(fn($conversion) => [
                    'id' => $conversion->id,
                    'course' => $conversion->relationLoaded('course') 
                        ? new CourseResource($conversion->course) 
                        : null,
                    'grade' => $conversion->grade,
                ])
            ),
        ];
    }
}
