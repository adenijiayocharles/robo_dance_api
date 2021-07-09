<?php

namespace App\Http\Resources;

use App\Models\Robot;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DanceOffTeamCollection extends ResourceCollection
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
            "contestants" => $this->collection->transform(function ($danceoffs) {
                return [
                    "id" => $danceoffs->id,
                    "contestant_one" => new RobotResource($danceoffs->contestantOne),
                    "contestant_two" => new RobotResource($danceoffs->contestantTwo),
                    "winner" => is_null($danceoffs->winner) ? null : new RobotResource(Robot::where("id", $danceoffs->winner)->first()),
                ];
            }),
        ];
    }
}
