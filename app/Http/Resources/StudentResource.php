<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'number' => $this->number,
            'department_id' => $this->department_id,
            'department_name' => $this->department ? $this->department->name : null,
            'guardian_number' => $this->guardian_number,
            'image' => $this->image,
        ];
    }
}
