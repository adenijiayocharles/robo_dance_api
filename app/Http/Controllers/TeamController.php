<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    public function create(CreateTeamRequest $request){
        Team::create([
            "name" => $request->input('name'),
            "manager_id" => auth()->user()->id
        ]);
        return auth()->user()->id;
    }
}
