<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'credit' => $this->credit,
            'semester' => $this->semester,
            'created_at' => $this->created_at,
            'is_open' => $this->is_open ? 'Open Semester' : 'Tidak'
        ];
    }
}
