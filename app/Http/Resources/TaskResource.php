<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'status'        => $this->status,
            'priority'      => $this->priority,
            'image'         => $this->image,
            'due_date'      => $this->due_date?->format('Y-m-d'),
            'created_at'    => $this->created_at->format('Y-m-d'),
            'project'       => new ProjectResource($this->project),
            'assigned_user' => new UserResource($this->assignedUser),
            'createdBy'     => new UserResource($this->createdBy),
            'updatedBy'     => new UserResource($this->updatedBy),
        ];
    }
}
