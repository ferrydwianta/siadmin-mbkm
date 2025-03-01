<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'start_time' => Carbon::parse($this->start_time)->format('H:i'),
            'end_time' => Carbon::parse($this->end_time)->format('H:i'),
            'date' => $this->date,
            'created_at' => $this->created_at,
            'academicYear' => $this->whenLoaded('academicYear', [
                'id' => $this->academicYear?->id,
                'name' => $this->academicYear?->name,
            ]),
            'activityRegistrations' => $this->whenLoaded('activityRegistrations', fn() => 
                $this->activityRegistrations->map(fn($registration) => [
                    'value' => $registration->id,
                    'student' => $registration->student->load('user'),
                    'activity' => $registration->activity
                ])->sortBy('label')->values()
            ),
        ];
    }
}
