<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
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
            'logo' => $this->logo ? Storage::url($this->url) : null,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
        ];
    }
}
