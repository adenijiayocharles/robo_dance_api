<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RobotTeamCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($robot_team) {
                return [
                    'id' => $robot_team->id,
                    'robot' => new RobotResource($robot_team->robot)
                ];
            }),
        ];
    }
}
