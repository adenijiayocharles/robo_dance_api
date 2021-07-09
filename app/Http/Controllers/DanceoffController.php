<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDanceoffRequest;
use App\Models\Team;
use App\Models\Danceoff;
use Illuminate\Http\Request;
use App\Http\Traits\Response;
use App\Models\RobotTeam;

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
        // check if team one exists
        if (is_null(Team::where('id', $request->input('team_one'))->first())) {
            return $this->sendError("Team one does not exists");
        }
        // check if team two exists
        if (is_null(Team::where('id', $request->input('team_two'))->first())) {
            return $this->sendError("Team two does not exists");
        }
        // check if team one has upto five members
        $checkTeamOne = RobotTeam::where('team_id', $request->input('team_one'))->get();
        if ($checkTeamOne->count() < 5) {
            return $this->sendError("Team one must have upto 5 members");
        }

        // check if team two has upto five members
        $checkTeamTwo = RobotTeam::where('team_id', $request->input('team_two'))->get();
        if ($checkTeamTwo->count() < 5) {
            return $this->sendError("Team two must have upto 5 members");
        }

        // create teams of five from both teams

        //save
        $dance = Danceoff::create([
            "team_one" => $request->input("team_one"),
            "team_two" => $request->input("team_two"),
        ]);

        return $this->sendResponse('Dance off has started');
    }
}
