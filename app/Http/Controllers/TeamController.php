<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRobotToTeamRequest;
use App\Models\Team;
use App\Models\RobotTeam;
use Illuminate\Http\Request;
use App\Http\Traits\Response;
use App\Http\Resources\TeamResource;
use App\Http\Resources\RobotCollection;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Resources\RobotTeamCollection;
use App\Models\Robot;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TeamController extends Controller
{
    use Response;

    /**
     * Create a new robot team
     *
     * @param   array  $request  [$request description]
     *
     * @return  json
     */
    public function createTeam(CreateTeamRequest $request)
    {
        $team = Team::create([
            "name" => $request->input("name"),
            "manager_id" => auth()->user()->id
        ]);
        return $this->sendResponse("Team created successfully", [
            "team" => new TeamResource($team)
        ], 201);
    }

    /**
     * Add a robot to a team
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function addRobotToTeam(AddRobotToTeamRequest $request)
    {

        // check if team already has team members
        $count = RobotTeam::where(["team_id" => $request->input("team_id"), "manager_id" => auth()->user()->id])->count();
        if ($count === 5) {
            return $this->sendError("Unable to add new member to this team has limit of 5 robot members has been reached");
        }

        //check if robot exists
        if (is_null(Robot::where("id", $request->input("robot_id"))->first())) {
            return $this->sendError("Robot does not exists");
        }

        //check if team exists
        if (is_null(Team::where("id", $request->input("team_id"))->first())) {
            return $this->sendError("Team does not exists");
        }

        // check if robot is a member of team already
        $check = RobotTeam::where([
            "team_id" => $request->input("team_id"),
            "robot_id" => $request->input("robot_id"),
            "manager_id" => auth()->user()->id
        ])->first();

        if (!is_null($check)) {
            return $this->sendError("Robot is already a member of this team");
        }

        // store tobot-team relationship in the database
        RobotTeam::create([
            "team_id" => $request->input("team_id"),
            "robot_id" => $request->input("robot_id"),
            "manager_id" => auth()->user()->id
        ]);
        return $this->sendResponse("Robot added to team successfully.", [], 201);
    }

    /**
     * Get the members of a team
     *
     * @param   integer  $team_id  id of team
     *
     * @return  json
     */
    public function getTeamMembers($team_id)
    {
        try {
            $results = Team::where("id", $team_id)->firstOrFail();
            return $this->sendResponse("Team found", [
                "team_details" => $results->name,
                "members" => new RobotCollection($results->robots)
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->sendError("Team not found", [], 404);
        }
    }
}
