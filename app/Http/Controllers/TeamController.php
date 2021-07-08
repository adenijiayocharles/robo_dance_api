<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Traits\Response;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Resources\TeamResource;

class TeamController extends Controller
{
    use Response;
    public function createTeam(CreateTeamRequest $request)
    {
        $team = Team::create([
            "name" => $request->input('name'),
            "manager_id" => auth()->user()->id
        ]);
        return $this->sendResponse('Team created successfully', [
            "team" => new TeamResource($team)
        ]);
    }
}
