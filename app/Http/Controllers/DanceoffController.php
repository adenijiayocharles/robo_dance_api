<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Danceoff;
use App\Models\RobotTeam;
use App\Models\DanceoffTeam;
use App\Http\Traits\Response;
use App\Http\Requests\CreateDanceoffRequest;
use App\Http\Resources\DanceOffTeamCollection;
use App\Http\Resources\DanceOffLeaderboardCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DanceoffController extends Controller
{
    use Response;

    /**
     * Start a new danceoff
     *
     * @return Json
     */
    public function create(CreateDanceoffRequest $request)
    {
        //check to see if ongoing danceoff between both teams exists
        $isOngoingDanceOff = Danceoff::where([
            "team_one" => $request->input("team_one"),
            "team_two" => $request->input("team_two"),
            "isComplete" => 0
        ])->first();

        if ($isOngoingDanceOff) {
            return $this->sendError("There is an ongoing danceoff between these teams");
        }

        // check if team one exists
        if (is_null(Team::where("id", $request->input("team_one"))->first())) {
            return $this->sendError("Team one does not exists");
        }
        // check if team two exists
        if (is_null(Team::where("id", $request->input("team_two"))->first())) {
            return $this->sendError("Team two does not exists");
        }

        // check if team one has upto five members
        $teamOne = RobotTeam::where("team_id", $request->input("team_one"))->pluck("robot_id")->toArray();
        if (count($teamOne) < 5) {
            return $this->sendError("Team one must have upto 5 members");
        }

        // check if team two has upto five members
        $teamTwo = RobotTeam::where("team_id", $request->input("team_two"))->pluck("robot_id")->toArray();
        if (count($teamTwo) < 5) {
            return $this->sendError("Team two must have upto 5 members");
        }

        shuffle($teamOne);
        shuffle($teamTwo);

        $contestants = [];
        foreach ($teamOne as $index => $value) {
            array_push($contestants, [$value, $teamTwo[$index]]);
        }

        //save
        $danceOff = Danceoff::create([
            "team_one" => $request->input("team_one"),
            "team_two" => $request->input("team_two"),
        ]);

        foreach ($contestants as $key => $contestant) {
            DanceoffTeam::create([
                "danceoff_id" => $danceOff->id,
                "contestant_one_id" => $contestant[0],
                "contestant_two_id" => $contestant[1],
            ]);
        }

        return $this->sendResponse("Dance off has started", [
            "danceoff" => $danceOff
        ]);
    }

    public function getDanceoffContestants($danceoff_id)
    {
        try {
            $danceOffs = Danceoff::where("id", $danceoff_id)->firstOrFail();
            return $this->sendResponse("Danceoff Found", new DanceOffTeamCollection($danceOffs->contestants));
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Dance off not found", [], 404);
        }
    }

    public function getDanceoffLeaderboard($danceoff_id)
    {
        try {
            $danceOffs = Danceoff::where("id", $danceoff_id)->firstOrFail();
            return $this->sendResponse("Danceoff Found", new DanceOffLeaderboardCollection($danceOffs->contestants));
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Dance off not found", [], 404);
        }
    }
}
