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
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'partner' => $this->whenLoaded('partner', [
                'id' => $this->partner?->id,
                'name' => $this->partner?->name,
                'description' => $this->partner?->description,
                'logo' => $this->partner?->logo ? Storage::url($this->partner?->logo) : null,
            ])
        ];
    }
}
