<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RobotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "powermove" => $this->powermove,
            "experience" => $this->experience,
            "outOfOrder" => $this->outOfOrder,
            "avatar" => $this->avatar
        ];
    }
}
