<?php

namespace App\Http\Resources\Student;

use App\Http\Resources\Admin\ActivityResource;
use App\Http\Resources\Admin\CourseResource;
use App\Http\Resources\Admin\ScheduleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityRegistrationStudentResource extends JsonResource
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
            'academicYear' => $this->whenLoaded('academicYear', [
                'id' => $this->academicYear?->id,
                'name' => $this->academicYear?->name,
                'semester' => $this->academicYear?->semester,
            ]),
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
