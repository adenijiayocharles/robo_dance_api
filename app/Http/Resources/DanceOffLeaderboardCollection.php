<?php

namespace App\Http\Resources;

use App\Models\Robot;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DanceOffLeaderboardCollection extends ResourceCollection
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
            'contestants' => $this->collection->transform(function ($danceoffs) {
                return [
                    'id' => $danceoffs->id,
                    'winner' => is_null($danceoffs->winner) ? null : new RobotResource(Robot::where('id', $danceoffs->winner)->first()),
                ];
            }),
        ];
    }
}
